@use('Kanata\LaravelBroadcaster\Conveyor')

<div x-data="{{ $liveComponentName }}"></div>

@php
    try {
        $token = Conveyor::getToken($channel);
    } catch (Exception|Error $e) {
        $token = '';
    }
@endphp
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('{{ $liveComponentName }}', () => ({
            init() {
                let that = this;

                window.connection = new window.Conveyor({
                    protocol: '{{ $protocol }}',
                    uri: '{{ $host }}',
                    port: {{ $port }},
                    channel: '{{ $channel }}',
                    token: '{{ $token }}',
                    onMessage: (e) => {
                        let data;
                        try {
                            data = JSON.parse(e);
                        } catch (error) {
                            console.warn(error.message, e);
                            data = e;
                        }

                        if (!data.message) return;
                        let parsedMessage = data.message;
                        {{ $callback }}(data.message);
                        window.dispatchEvent(new CustomEvent('onConveyorMessage', {detail: parsedMessage}));
                        that.$wire.onMessage(data.message);
                    },
                    reconnect: true,
                });
            }
        }));
    });
</script>
