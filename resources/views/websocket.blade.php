<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="container">
        <div>
            <ul id="list-message">
                
            </ul>
            <form id="form" method="POST">
                @csrf
                <label>Enter your message: </label>
                <input type="text" name="message" id="input-message" />
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
    </div>

    @vite('resources/js/app.js')
</body>

</html>