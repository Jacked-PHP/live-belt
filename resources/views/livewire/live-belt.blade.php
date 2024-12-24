@use('Kanata\LaravelBroadcaster\Conveyor')

<div x-data="{{ $liveComponentName }}"></div>

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
                    token: '{{ Conveyor::getToken($channel) }}',
                    onMessage: (e) => {
                        try {
                            let data = JSON.parse(e);
                            if (!data.message) return;
                            let parsedMessage = JSON.parse(data.message);
                            {{ $callback }}(data.message);
                            window.dispatchEvent(new CustomEvent('onConveyorMessage', {detail: parsedMessage}));
                            that.$wire.onMessage(data.message);
                        } catch (error) {
                            console.warn(error.message, e);
                        }
                    },
                    reconnect: true,
                });
            }
        }));
    });
</script>
