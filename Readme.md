# Live Belt

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
    Jacked\LiveBelt\Providers\LiveBeltServiceProvider::class,
],
````

```bash
php artisan vendor:publish --provider="LiveBelt\LiveBeltServiceProvider"
```

### Step 3: install dependencies for JS

```bash
npm install --save socket-conveyor-client
```

Then add this to your `app.js`:

```js
import Conveyor from "socket-conveyor-client";

window.Conveyor = Conveyor;
```

