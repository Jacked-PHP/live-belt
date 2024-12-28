<?php

namespace LiveBelt;

use Illuminate\Support\ServiceProvider;
use LiveBelt\Livewire\LiveBelt as LivewireLiveBelt;
use Livewire\Livewire;

class LiveBeltServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/live-belt.php', 'live-belt');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'live-belt');
        Livewire::component('live-belt', LivewireLiveBelt::class);

        $this->publishes([
            __DIR__.'/../config/live-belt.php' => config_path('live-belt.php')
        ], 'live-belt-config');
    }
}
