<?php

namespace LiveBelt\Livewire;

use Error;
use Exception;
use Kanata\LaravelBroadcaster\Conveyor;
use LiveBelt\Events\OnConveyorMessage;
use Livewire\Component;

class LiveBelt extends Component
{
    public string $liveComponentName;
    public string $channel;
    public ?string $host = null;
    public ?int $port = null;
    public ?string $protocol = null;
    public ?string $callback;

    public function mount(
        string $channel,
        ?string $host = null,
        ?int $port = null,
        ?string $protocol = null,
        ?string $callback = null
    ) {
        if (strlen($channel) > 40) {
            report(new Exception('Channel name can\'t have more than 40 characters'));
            return;
        }

        $this->liveComponentName = 'livebelt' . uniqid();
        $this->protocol = $protocol ?? config('broadcasting.connections.conveyor.protocol');
        $this->host = $host ?? config('broadcasting.connections.conveyor.host');
        $this->port = $port ?? config('broadcasting.connections.conveyor.port');
        $this->channel = $channel;
        $this->callback = $callback;
    }

    public function onMessage(string $data): void
    {
        event(new OnConveyorMessage($data));
    }

    public function getToken(): string
    {
        try {
            return Conveyor::getToken($this->channel);
        } catch (Exception|Error $e) {
            return '';
        }
    }

    public function render()
    {
        return view('live-belt::livewire.live-belt', [
            'token' => $this->getToken(),
        ]);
    }
}
