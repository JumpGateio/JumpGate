<?php

namespace Database\Factories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JumpGate\Users\Models\User\Social;

class SocialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Social::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'       => User::factory(),
            'provider'      => $this->faker->randomElement([
                'google',
                'discord',
                'steam',
            ]),
            'social_id'     => $this->faker->uuid,
            'email'         => $this->faker->email,
            'avatar'        => $this->faker->imageUrl(),
            'token'         => encrypt('token'),
            'refresh_token' => encrypt('token'),
            'expires_in'    => 604800,
        ];
    }
}
