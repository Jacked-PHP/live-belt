<?php

namespace LiveBelt;

use Illuminate\Support\ServiceProvider;
use LiveBelt\Livewire\LiveBelt;
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
        Livewire::component('live-belt', LiveBelt::class);
    }
}
