<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .header {
            background: #03A9F4;
            display: flex;
            padding: 10px;
            align-items: center;
            justify-content: space-between;
        }

        .container {
            width: 400px;
            padding: 10px;
        }

        .header h3 {
            color: white;
        }

        .header label {
            background: #FFC107;
            padding: 10px;
            border-radius: 20px;
        }

        .body {
            background: #8080802e;
            padding: 10px;
            height: 300px;
        }

        .body .message {
            background: #6495ed7a;
            padding-left: 5px;
            width: 150px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .body .message .mes-name {
            color: #0a83e3;
            font-size: 15px;
            padding-top: 5px;
            margin: 0px;
        }

        .footer input {
            padding: 10px;
            width: 100%;
            border: none;
        }

        .footer {
            overflow: hidden;
        }

        .conversation-block {
            box-shadow: 0px 1px 2px 2px grey;
        }

        .footer input:focus {
            outline: none;
        }
    </style>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="container">
        <div>
            <form id="form-group" method="POST">
                @csrf
                <div class="conversation-block">
                    <div class="header">
                        <div class="row">
                            <h3>Chat</h3>
                        </div>
                        <div class="row">
                            <label>NK</label>
                            <label>LR</label>
                        </div>
                    </div>
                    <div class="body" id="list-message">
                        <div class="message">
                            <h4 class="mes-name">Leola Ruecker</h4>
                            <div class="mes-content">aaaaa</div>
                        </div>
                    </div>
                    <div class="footer">
                        <input type="text" name="message" id="input-message" placeholder="Type a message" />
                    </div>
                </div>
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

    @vite('resources/js/app_group.js')
</body>

</html>