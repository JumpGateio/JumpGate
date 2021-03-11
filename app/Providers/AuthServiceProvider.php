<?php

namespace App\Providers;

use BinaryTorch\LaRecipe\DocumentationRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Str;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Uncomment this if you enable users.
        // $this->handleLaRecipe();
    }

    /**
     * @todo Need to test this once users are added in.s
     */
    protected function handleLaRecipe()
    {
        Gate::define('viewLarecipe', function ($user, DocumentationRepository $documentation) {
            $section     = $documentation->getCurrentSectionAttribute();
            $lockedAreas = ['admin', 'dev', 'mod'];

            if (! Str::startsWith($section, $lockedAreas)) {
                return true;
            }

            $roles = \JumpGate\Users\Models\Role::all();

            foreach ($lockedAreas as $lockedArea) {
                // Make sure we get the full role for validation.
                $role = $roles
                    ->filter(function ($role) use ($lockedArea) {
                        return Str::startsWith($role->name, $lockedArea);
                    })
                    ->first();

                if (Str::startsWith($section, $lockedArea) && ! auth()->user()->hasRole($role->name)) {
                    return false;
                }
            }

            return true;
        });
    }
}
