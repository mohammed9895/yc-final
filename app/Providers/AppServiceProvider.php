<?php

namespace App\Providers;

use Filament\Facades\Filament;
use App\Filament\Pages\Profile;
use Illuminate\Foundation\Vite;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use JeffGreco13\FilamentBreezy\FilamentBreezy;
use JeffGreco13\FilamentBreezy\Pages\MyProfile;
use Laravel\Fortify\Contracts\ResetPasswordViewResponse;
use Illuminate\Contracts\Support\Responsable;
use     App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ResetPasswordViewResponse::class, function ($app) {
            return new class implements ResetPasswordViewResponse, Responsable
            {
                public function toResponse($request)
                {
                    // Replace this with the path to your custom reset password view
                    // return view('filament-breezy::reset-password');
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // $users = User::all();

        // foreach ($users as $user) {
        //     if ($user->avatar == 'en') {
        //         $user->avatar = 'user.jpg';
        //         $user->save();
        //     }
        // }

        Validator::extend('triple_name', function ($attribute, $value, $parameters, $validator) {
            $names = explode(' ', $value);
            return count($names) >= 3;
        });

        Filament::serving(function () {
            // Filament::registerViteTheme('resources/css/filament.css');
            Filament::registerUserMenuItems([
                'account' => UserMenuItem::make()->url(route('filament.pages.profile')),
            ]);
            Filament::registerViteTheme('resources/css/filament.css');
        });

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label(__('workshops')),

                NavigationGroup::make()
                    ->label(__('halls')),

                NavigationGroup::make()
                    ->label(__('users')),
            ]);
            Filament::registerUserMenuItems([
                'account' => UserMenuItem::make()->url(Profile::getUrl()),
            ]);
        });
    }
}
