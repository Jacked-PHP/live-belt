<?php

namespace LiveBelt;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use LiveBelt\Livewire\LiveBelt as LivewireLiveBelt;
use Livewire\Livewire;
use LiveBelt\Components\LiveBelt;

class LiveBeltServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/live-belt.php', 'live-belt');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'live-belt');
        Blade::component('live-belt', LiveBelt::class);
        Livewire::component('live-belt', LivewireLiveBelt::class);

        $this->publishes([
            __DIR__.'/../config/live-belt.php' => config_path('live-belt.php')
        ], 'live-belt-config');
    }
}
