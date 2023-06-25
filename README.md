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
PUSHER_APP_ID=testwebsocket\n
PUSHER_APP_KEY=qwerty\n
PUSHER_APP_SECRET=1234\n
PUSHER_HOST=localhost\n
PUSHER_PORT=80\n
PUSHER_SCHEME=http\n
PUSHER_APP_CLUSTER=mt1

- **[error]
- Exception `BeyondCode\LaravelWebSockets\Exceptions\InvalidApp` thrown: `appSecret is required but was empty for app id `testwebsocket`.`
Unknown app id: exception `BeyondCode\LaravelWebSockets\Exceptions\InvalidApp` thrown: `appSecret is required but was empty for app id `testwebsocket`.
-> restart

- **[Note]
+ Uncomment: App\Providers\BroadcastServiceProvider::class on config/app.php
+ HelloEvent implements ShouldBroadcast

https://www.youtube.com/watch?v=AUlbN_xsdXg&ab_channel=Acadea.io


- **[Laravel Echo]**
- npm i laravel-echo pusher-js

- **[Laravel mix -> vite]**
- npm run dev