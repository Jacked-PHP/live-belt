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
                    onCloseCallback: async () => {
                        window.connection.options.token = await that.$wire.getToken();
                    },
                    reconnect: true,
                });
            }
        }));
    });
</script>
