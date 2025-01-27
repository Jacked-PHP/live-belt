<div x-data="{{ $liveComponentName }}"></div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('{{ $liveComponentName }}', () => ({
            ws: null,
            channel: '{{ $channel }}',

            init() {
                let that = this;

                this.ws = new window.Conveyor({
                    protocol: '{{ $protocol }}',
                    uri: '{{ $host }}',
                    port: {{ $port }},
                    channel: this.channel,
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
                        if (window.connection) {
                            window.connection.options.token = await that.$wire.getToken();
                        }
                    },
                    onReady: () => {
                        window.addEventListener('onConveyorMessageBroadcast', that.sendMessage.bind(that));
                    },
                    reconnect: true,
                    acknowledge: true,
                });
            },

            sendMessage(e) {
                if (e.detail.channel !== this.channel) return;
                this.ws.send(e.detail.message, 'broadcast-action');
            },
        }));
    });
</script>
