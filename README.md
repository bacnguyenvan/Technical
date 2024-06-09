1. Telegram

- **[document](https://github.com/laravel-notification-channels/telegram)**
document: https://github.com/laravel-notification-channels/telegram

2. Web socket

- **[document](https://beyondco.de/docs/laravel-websockets/getting-started/installation)**

- **[composer require beyondcode/laravel-websockets --with-all-dependencies]**
- **[composer require pusher/pusher-php-server]**

- **[php artisan websockets:serve]**
- The default location of the WebSocket dashboard is at /laravel-websockets

- **[config]
PUSHER_APP_ID=testwebsocket
PUSHER_APP_KEY=qwerty
PUSHER_APP_SECRET=1234
PUSHER_HOST=localhost
PUSHER_PORT=80
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1

- **[error]
- Exception `BeyondCode\LaravelWebSockets\Exceptions\InvalidApp` thrown: `appSecret is required but was empty for app id `testwebsocket`.`
Unknown app id: exception `BeyondCode\LaravelWebSockets\Exceptions\InvalidApp` thrown: `appSecret is required but was empty for app id `testwebsocket`.
-> restart

- **[Note]
+ Uncomment: App\Providers\BroadcastServiceProvider::class on config/app.php
+ HelloEvent implements ShouldBroadcast

3. DI
NotifyInterface

