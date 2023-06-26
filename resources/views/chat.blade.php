<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>chat app - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('chat/style.css')}}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <style>
        .content-chat {
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>User: {{ optional(auth()->user())->name }}</h2>
        <div class="row clearfix content-chat">
            <div class="col-lg-12">
                @if(count($lists))
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            @foreach($lists as $key => $item)
                               
                                <li class="user-chat clearfix {{$key == 0 ? 'active':''}}">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                    <div class="about">
                                        <div class="name">{{$item->name}}</div>
                                        <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>
                                    </div>
                                </li>
                                
                            @endforeach
                        </ul>
                    </div>
                    <div class="chat">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <h6 class="m-b-0">{{$lists[0]->name}}</h6>
                                        <small>Last seen: 2 hours ago</small>
                                    </div>
                                </div>
                                <div class="col-lg-6 hidden-sm text-right">
                                    <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                                    <a href="{{route('logout')}}" class="btn btn-outline-info"><i class="fa fa-sign-out"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history">
                            <ul class="m-b-0" id="content-converstation">
                                @foreach($conversations as $c)
                                <li class="clearfix">
                                    <div class="message-data {{($c->sender_id == auth()->user()->id)?'text-right' : 'text-left'}}">
                                        <span class="message-data-time">{{$c->created_at}}</span>
                                        @if(($c->sender_id == auth()->user()->id))
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                        @endif
                                    </div>
                                    <div class="message {{($c->sender_id == auth()->user()->id)?'other-message float-right' : 'my-message'}}"> {{$c->content}} </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="chat-message clearfix">
                            <form id="form">
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-send"></i></span>
                                    </div>
                                    <input type="text" id="input-message" class="form-control" placeholder="Enter text here...">
                                </div>
                                <input type="hidden" value="{{auth()->user()->id}}" id="s_id"/>
                                <input type="hidden" value="{{$lists[0]->id}}" id="r_id"/>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="card">
                    <h4>There are not any conversations</h4>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.user-chat').on('click', function(){
                $('.user-chat').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
    @vite('resources/js/app.js')
</body>

</html>