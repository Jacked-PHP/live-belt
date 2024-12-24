<div>

</div>

<script>
    window.connection = new Conveyor({
        protocol: '{{ $protocol }}',
        uri: {{ $uri }},
        port: {{ $wsPort }},
        channel: '{{ $channel }}',
        onMessage: (e) => {
            document.getElementById('output').innerHTML = e;
        },
        onReady: () => {
            connection.send('Welcome!');
        },
    });
</script>
