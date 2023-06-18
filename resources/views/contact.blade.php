<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Contact</title>
    </head>
    <body class="antialiased">
        <div>
            <form method="POST">
                @csrf
                <label>Enter your content: </label>
                <input type="text" name="content"/>
                <button type="submit">Send</button>
            </form>
            @if(session('msg'))
            <div class="alert" style="color: green">
                {{session('msg')}}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $error)
                    <li> {{ $error }} </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </body>
</html>
