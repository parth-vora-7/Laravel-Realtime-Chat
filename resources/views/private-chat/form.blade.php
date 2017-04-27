@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Private Chat</div>
                <div class="panel-body">
<<<<<<< HEAD
                    <form id="group-chat" class="form-horizontal" role="form" method="POST" action="{{ route('private.chat.store', $chatroom->id) }}" @submit.prevent="sendPrivateMessage">
=======
                    <form id="group-chat" class="form-horizontal" role="form" method="POST" action="{{ route('private.chat.store', $chatRoom->id) }}">
>>>>>>> 19055efaf6541cf31c16a20425946d90b828df02
                        {{ csrf_field() }}
                        <div class="chat-messages">
                            @if($messages->count())
                            @foreach($messages as $message)
                            <div>
                                <b class="sender">{{ $message->sender->name }}:</b>
                                <p class="message">{{ $message->message }}</p>
                            </div>
                            @endforeach
                            @else
                            <div class="alert alert-warning">No chat yet!</div>
                            @endif
                        </div>
                        <span class="typing hidden"><i><span></span>is typing</i></span>
                        <hr/>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} chat-box">
                            <div class="col-md-10">
                                <textarea v-model="message" type="textarea" class="form-control" name="message" required autofocus></textarea>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-2 chat-btn">
                                <button type="submit" class="btn btn-primary">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('chat')
<script>
<<<<<<< HEAD
    window.Echo.private(`private-chat-room.${ {{$chatroom->id}} }`)
=======
    window.Echo.private(`chat.room.${ {{$chatRoom->id}} }`)
>>>>>>> 19055efaf6541cf31c16a20425946d90b828df02
    .listen('PrivateMessageEvent', (e) => {
        app.updateChat(e);
    });
    $('#chat-message').keypress(function (e) {
        Echo.private(`chat.${ {{$chatRoom->id}} }`)
        .whisper('typing', {
            name: "{{ auth()->user()->name }}"
        });
        if (e.which == 13) {
            $('#group-chat').submit();
            return false;
        }
    });
<<<<<<< HEAD
    /*Echo.private(`chat.${ {{$chatroom->id}} }`)
=======
    Echo.private(`chat.${ {{$chatRoom->id}} }`)
>>>>>>> 19055efaf6541cf31c16a20425946d90b828df02
    .listenForWhisper('typing', (e) => {
        var ele = $('.typing');
        ele.find('span').text(e.name);
        ele.removeClass('hidden').delay(1000).queue(function(next){
<<<<<<< HEAD
           ele.addClass('hidden')
           next();
       });
    });*/
=======
         ele.addClass('hidden')
         next();
     });
    });
>>>>>>> 19055efaf6541cf31c16a20425946d90b828df02
</script>
@endsection
