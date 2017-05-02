@extends('layouts.app')

@section('routes')
var fetchChatURL = "{{ route('fetch-private.chat', $chatRoom->id) }}";
var savePrivateChatURL = "{{ route('private.chat.store', $chatRoom->id) }}";
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Private Chat with {{ $receiver->name }}</div>
                <div class="panel-body">
                    <form id="group-chat" class="form-horizontal" role="form" method="POST" @submit.prevent="sendPrivateMessage">
                        {{ csrf_field() }}
                        <div id="messages">
                            <div v-if="messages.length">
                                <message v-for="message in messages" key="message.id" :sender="message.sender.name" :message="message.message" :createdat="message.created_at"></message>
                            </div>
                            <div v-else>
                                <div class="alert alert-warning">No chat yet!</div>
                            </div>
                        </div>
                        <span class="typing" v-if="isTyping"><i><span>@{{ isTyping }}</span>is typing</i></span>
                        <hr/>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} chat-box">
                            <div class="col-md-10">
                                <textarea v-model="message" type="textarea" class="form-control" name="message" @keyup.enter="sendPrivateMessage" @keypress="userIsTyping({{$chatRoom->id}})" required autofocus></textarea>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-2 chat-btn">
                                <button type="submit" class="btn btn-primary" :disabled="!message">
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

@section('script')
<script>
    window.Echo.private(`private-chat-room-{{$chatRoom->id}}`)
    .listen('PrivateMessageEvent', (e) => {
        app.updateChat(e);
    });

    window.Echo.private(`typing-room-{{$chatRoom->id}}`)
    .listenForWhisper('typing', (e) => {
        app.isTyping = e.name;
        setTimeout(function() {
            app.isTyping = '';
        }, 1000);
    });
</script>
@endsection
