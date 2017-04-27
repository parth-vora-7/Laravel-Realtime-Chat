@extends('layouts.app')

@section('script')
<script>
    var groupMessageRoute = "{{ route('group.chat.store') }}";
    var loggedInUser = {!! json_encode(auth()->user()) !!};
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Group Chat</div>
                <div class="panel-body">
                    <form id="group-chat" class="form-horizontal" role="form" method="POST" @submit.prevent="sendGroupMessage">
                        {{ csrf_field() }}
                        <div class="chat-messages">
                            @if($chat->count())
                            @foreach($chat as $message)
                            <pv-message sender="{{ $message->sender->name }}" message="{{ $message->message }}"></pv-message>
                            @endforeach
                            @else
                            <div class="alert alert-warning">No chat yet!</div>
                            @endif
                        </div>
                        <span class="typing hidden"><i><span></span>is typing</i></span>
                        <hr/>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} chat-box">
                            <div class="col-md-10">
                                <textarea v-model="message" @keyup.enter="sendGroupMessage" @keyup="userIsTyping" type="textarea" class="form-control" required autofocus></textarea>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-2 chat-btn">
                                <button class="btn btn-primary">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Online users</div>
                <div class="panel-body">
                    <ul class="online-users">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('chat')
<script type="text/javascript">
    Echo.join('groupjoined')
    .here((users) => {
        $.each(users, function( index, value ) {
            $('.online-users').append('<li id="user-status-' + value.id + '">' + value.name + '</li>')
        });
    })
    .joining((user) => {
        $.notify(user.name +' joined', 
        {
            clickToHide: true,
            autoHide: true,
            arrowShow: false,
            autoHideDelay: 2000,
            className: 'success',
        });
        $('.online-users').append('<li id="user-status-' + user.id + '">' + user.name + '</li>')
    })
    .leaving((user) => {
        $.notify(user.name +' left', 
        {
            clickToHide: true,
            autoHide: true,
            arrowShow: false,
            autoHideDelay: 2000,
            className: 'error',
        });
        $('.online-users li[id=user-status-' + user.id + ']').remove();
    });

    window.Echo.channel('groupchat')
    .listen('GroupMessageEvent', (e) => {
        app.updateChat(e);
    });
</script>
@endsection