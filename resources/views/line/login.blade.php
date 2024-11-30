<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Line Login</title>
    <style>
        .social-button {                                                                        
            background-position: 25px 0;
            box-sizing: border-box;
            color: rgb(255, 255, 255);
            cursor: pointer;
            display: inline-block;
            height: 50px;
            line-height: 50px;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            vertical-align: middle;
            width: 20%;
            border-radius: 5px;
            margin: 10px auto;
        }

        #line {
            background: #00C300;
        }

        #line span {
            box-sizing: border-box;
            color: #ffffff;
            cursor: pointer;
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="col-sm-12">
            <a href="{{$authUrl}}" class="social-button" id="line">
                <span> LINE Login</span>
            </a>
        </div>
    </div>
</body>

</html>