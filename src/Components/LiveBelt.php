<?php

namespace LiveBelt\Components;

use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LiveBelt extends Component
{
    public string $protocol;
    public string $host;
    public int $port;
    public string $channel;
    public string $callback;

    public function __construct(
        string $channel,
        ?string $host = null,
        ?int $port = null,
        ?string $protocol = null,
        string $callback = 'console.log',
    ) {
        if (strlen($channel) > 40) {
            report(new Exception('Channel name can\'t have more than 40 characters'));
            return;
        }

        $this->protocol = $protocol ?? config('broadcasting.connections.conveyor.protocol');
        $this->host = $host ?? config('broadcasting.connections.conveyor.host');
        $this->port = $port ?? config('broadcasting.connections.conveyor.port');
        $this->channel = $channel;
        $this->callback = $callback;
    }

    public function render(): View|Closure|string
    {
        return view('live-belt::livewire.live-belt');
    }
}
