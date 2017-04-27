<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});*/

Broadcast::channel('private-chat-room.{message}', function ($user, $message) {
	if($user->id == $message->sender_id || $user->id == $message->receivers->first()->receiver_id) {
		return true;
	} else {
		return false;
	}
});

Broadcast::channel('chat.{chatRoomId}', function ($user, $chatRoomId) {
	$participants = collect(App\ChatRoom::where('id', $chatRoomId)->first(['sender_id', 'receiver_id'])->toArray());
	
	if($participants->contains($user->id)) {
		return true;
	} else {
		return false;
	}
});

Broadcast::channel('chat', function ($user) {
	return true;
});

Broadcast::channel('groupjoined', function ($user) {
	return $user;
});