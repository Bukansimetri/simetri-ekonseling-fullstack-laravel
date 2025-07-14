<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Fortify\Responses\LoginViewResponse;
use App\Fortify\Responses\RegisterViewResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\LoginViewResponse as LoginViewResponseContract;
use Laravel\Fortify\Contracts\RegisterViewResponse as RegisterViewResponseContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind Fortify View Responses
        $this->app->bind(LoginViewResponseContract::class, LoginViewResponse::class);
        $this->app->bind(RegisterViewResponseContract::class, RegisterViewResponse::class);
        $this->app->bind(CreatesNewUsers::class, CreateNewUser::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $student = $user?->student;
            $counselor = $user?->counselor;
            $view->with('currentUser', $user)
                ->with('currentStudent', $student)
                ->with('currentCounselor', $counselor);
        });
    }
}
