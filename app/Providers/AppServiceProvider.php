<?php

namespace k1fl1k\truefalsegame\Providers;

use k1fl1k\truefalsegame\App\Livewire\Profile\FavoriteGamesForm;
use k1fl1k\truefalsegame\App\Livewire\Profile\UserGamesForm;
use Illuminate\Support\ServiceProvider;
use k1fl1k\truefalsegame\App\Livewire\Profile\ProfileInformationForm;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('profile.profile-information-form', ProfileInformationForm::class);
        Livewire::component('profile.user-games-form', UserGamesForm::class);
        Livewire::component('profile.favorite-games-form', FavoriteGamesForm::class);
    }
}
