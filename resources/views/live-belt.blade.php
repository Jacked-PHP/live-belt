@use('Kanata\LaravelBroadcaster\Conveyor')
@props(['callback' => 'console.log'])
<script>
    document.addEventListener("DOMContentLoaded", () => {
        window.connection = new window.Conveyor({
            protocol: '{{ $protocol }}',
            uri: '{{ $host }}',
            port: {{ $port }},
            channel: '{{ $channel }}',
            token: '{{ Conveyor::getToken($channel) }}',
            onMessage: (e) => {
                try {
                    let data = JSON.parse(e);
                    if (data.message) {{ $callback }}(data.message);
                } catch (error) {
                    console.warn(error.message);
                }
            },
            reconnect: true,
        });
    });
</script>
