# Live Belt

Livewire Component for Real Time interactions using Laravel Conveyor Driver.

Video: https://www.youtube.com/watch?v=nQgMK2r_gww

## Installation

### Step 1: install package

```bash
composer require jacked-php/live-belt
```

### Step 2: add service provider

Add the following to your `bootstrap/providers.php` file:

```php
<?php

return [
    // ...
    Kanata\LaravelBroadcaster\ConveyorServiceProvider::class,
    LiveBelt\LiveBeltServiceProvider::class,
],
````

### Step 3: install dependencies for JS

```bash
php artisan install:broadcasting --without-reverb --without-node
npm install --save socket-conveyor-client
```

Comment `import './echo';` from `resources/js/bootstrap.js`.

Then add this to your `app.js`:

```js
import Conveyor from "socket-conveyor-client";

window.Conveyor = Conveyor;
```

At this stage, be sure to follow the steps 1 to 5 at the [Laravel Conveyor Driver documentation](https://socketconveyor.com/docs/laravel-driver).

### Step 4: adjust configuration

Add the following to your `config/broadcasting.php` file:

```php
<?php

return [
    // ...
    'conveyor' => [
        'driver' => 'conveyor',
        'protocol' => env('CONVEYOR_PROTOCOL', 'ws'),
        'host' => env('CONVEYOR_URI', 'localhost'),
        'port' => env('CONVEYOR_PORT', 8181),
    ],
];
```

Set the configurations for the WebSocket server in the `.env` file:

```dotenv
# ...
BROADCAST_CONNECTION=conveyor
# ...
CONVEYOR_URI=127.0.0.1
CONVEYOR_PORT=8181
CONVEYOR_QUERY="token=my-secure-conveyor-token"
# ...
```

## Usage

First, check the [Laravel Conveyor Driver documentation](https://socketconveyor.com/docs/laravel-driver) to set up your Laravel project.

Add this to your scripts area:

```html
<livewire:live-belt
    :channel="'private-notifications-' . auth()->id()"
    callback="console.log"
/>
```

This example will write to your console log.

You can communicate with it using this example event:

```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NotificationReady implements ShouldBroadcastNow
{
    use InteractsWithBroadcasting;

    public function __construct(
        public string $message,
        public string $channel,
    ) {
        $this->broadcastVia('conveyor');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel($this->channel),
        ];
    }
}
```

Dispatch it like this and see the console log of your browser:

```php
event(new NotificationReady( message: 'Message from Conveyor', channel: 'notifications-{your-user-id-here}')); // remember to replace {your-user-id-here} with your user id
```

## Notes

- There will be logs in the browser console in case of errors (shown as warnings).
