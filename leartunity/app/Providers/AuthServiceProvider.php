<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Profile;
use App\Policies\ProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Profile::class => ProfilePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define("change-pic", function(User $user, Profile $profile) {
            return auth()->user()->profile->is($profile);
        });

        Gate::define("teach", function(User $user) {
            return auth()->user()->role === "instructor" || auth()->user()->role === "admin";
        });

        Gate::define("admin", function(User $user) {
            return auth()->user()->role === "admin";
        });
    }
}
