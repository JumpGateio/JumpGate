<?php

namespace App\Services\Users\Managers;


use App\Services\Users\Events\UserLoggedIn;
use App\Services\Users\Events\UserLoggingIn;
use App\Services\Users\Models\Social\Provider;
use App\Services\Users\Models\User;
use JumpGate\Database\Collections\SupportCollection;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Facades\Socialite;

class SocialLogin
{
    protected array|SupportCollection $providers;

    public ?Provider $provider = null;

    private User $users;

    /**
     * @param User $users
     */
    public function __construct(User $users)
    {
        $this->users     = $users;
        $this->providers = supportCollector(config('jumpgate.users.providers'))
            ->keyBy('driver');
    }

    /**
     * Redirect the user based on the social provider being used.
     *
     * @param string|null $provider The provider being logged in through.
     *
     * @return mixed
     * @throws \Exception
     */
    public function redirect(?string $provider): mixed
    {
        $this->setProviderDetails($provider);

        return Socialite::driver($this->provider->driver)
            ->scopes($this->provider->scopes)
            ->with($this->provider->extras)
            ->redirect();
    }

    /**
     * Try to log the user in and validate their status.
     *
     * @param string $provider The provider being logged in through.
     *
     * @return array
     * @throws \Exception
     */
    public function loginUser(string $provider): array
    {
        $this->setProviderDetails($provider);

        $socialUser = $this->getSocialUser();

        // Allow any checks before creating/updating the user.
        event(new UserLoggingIn($socialUser));

        $user = $this->getUser($socialUser);

        // Update or create provider details.
        $this->updateFromProvider($user, $socialUser);

        // Log the user in.
        auth()->login($user, request('remember', false));
        $user->updateLogin($this->provider->driver);
        event(new UserLoggedIn($user, $socialUser));

        return [
            $user,
            $socialUser,
        ];
    }

    /**
     * Update a user's social details fore a given provider.
     *
     * @param string $provider The provider being logged in through.
     * @param User   $user     The user these details are for.
     *
     * @return AbstractUser|null
     * @throws \Exception
     */
    public function socialUpdate(string $provider, User $user): ?AbstractUser
    {
        $this->setProviderDetails($provider);

        // Get the users.
        $socialUser = $this->getSocialUser();

        // Update or create provider details.
        $this->updateFromProvider($user, $socialUser);

        return $socialUser;
    }

    /**
     * Get the social user from Socialite.
     *
     * @return AbstractUser|null
     */
    protected function getSocialUser(): ?AbstractUser
    {
        return Socialite::driver($this->provider->driver)->user();
    }

    /**
     * Make sure that we have a valid user to work with.
     *
     * @param AbstractUser|null $socialUser
     *
     * @return User
     */
    protected function getUser(?AbstractUser $socialUser): User
    {
        $user = $this->users
            ->where('email', $socialUser->getEmail())
            ->orWhereHas('socials', function ($query) use ($socialUser) {
                $query->where('email', $socialUser->getEmail())
                    ->where('provider', $this->provider->driver);
            })->first();

        if (! is_null($user)) {
            return $user;
        }

        return app(Registration::class)
            ->registerSocialUser($socialUser, $this->provider->driver);
    }

    /**
     * Either update an existing provider record with the newest details
     * or add this provider to the user.
     *
     * @param User|null         $user
     * @param AbstractUser|null $socialUser
     *
     * @return mixed
     */
    protected function updateFromProvider(?User $user, ?AbstractUser $socialUser): mixed
    {
        if (! $user->hasProvider($this->provider->driver)) {
            return $user->addSocial($socialUser, $this->provider->driver);
        }

        return $user->getProvider($this->provider->driver)
            ->updateFromProvider($socialUser, $this->provider->driver);
    }

    /**
     * Find the provider's driver, scopes and extras based on a given provider name.
     *
     * @param string|null $provider The name of the provider.
     *
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    public function setProviderDetails(?string $provider): void
    {
        $this->validateProviders();

        $this->setProvider($provider);

        $this->validateDriver();
    }

    /**
     * Make sure we have a valid array of drivers.
     *
     * @throws \Exception
     */
    private function validateProviders(): void
    {
        if (empty($this->providers)) {
            throw new \Exception('No Providers have been set in users config.');
        }
    }

    /**
     * Get the provider from the supplied name.
     *
     * @param string|null $providerName The name of the provider.
     *
     * @return Provider
     */
    private function setProvider(?string $providerName): void
    {
        $provider = is_null($providerName)
            ? $this->providers->first()
            : $this->providers->get($providerName);

        $this->provider = new Provider($provider);
    }

    /**
     * Make sure that the provider has a driver set.
     *
     * @throws \InvalidArgumentException
     */
    private function validateDriver(): void
    {
        if (is_null($this->provider->driver)) {
            throw new \InvalidArgumentException('You must set a social driver to use the social authenticating features.');
        }
    }
}
