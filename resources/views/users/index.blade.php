<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Contact</title>
    </head>
    <body class="antialiased">
        <div>
            <h2>Login with one of users list below</h2>
            <ul>
                @foreach(\App\Models\User::all() as $user)
                    <li>
                        <a href="/login/{{$user->id}}">{{$user->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </body>
</html>
