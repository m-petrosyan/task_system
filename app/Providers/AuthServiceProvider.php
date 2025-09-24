<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('owner', function (User $user, Model $model) {
            return $user->id === $model->user_id;
        });

        Gate::define('assigned', function (User $user, Model $model) {
            return $user->id === $model->assigned_user_id;
        });
    }
}
