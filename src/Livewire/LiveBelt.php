<?php

namespace LiveBelt\Livewire;

use App\Enums\ContextData;
use Illuminate\Support\Facades\Context;
use Livewire\Component;

class LiveBelt extends Component
{
    public string $protocol;
    public string $uri;
    public int $port;
    public string $channel;
    public $callback;

    public function mount(
        string $protocol,
        string $uri,
        int $port,
        string $channel,
        callable $callback,
    ) {
        $this->protocol = $protocol;
        $this->uri = $uri;
        $this->port = $port;
        $this->channel = $channel;
        $this->callback = $callback;
    }

    public function render()
    {
        return view('live-belt::livewire.live-belt');
    }
}
