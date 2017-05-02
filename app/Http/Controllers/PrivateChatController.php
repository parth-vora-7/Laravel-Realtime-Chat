<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PrivateMessageEvent;
use App\Models\User;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\Receiver;

class PrivateChatController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function get(ChatRoom $chatroom)
    {
        return $chatroom->messages;
    }

    public function index($receiverId)
    {
        $receiver = User::find($receiverId);
        $senderUserId = auth()->user()->id;
        $roomMembers = [$receiverId, $senderUserId];
        sort($roomMembers);
        $roomMembers = implode($roomMembers, ',');
        
        $chatRoom = ChatRoom::where('user_ids', $roomMembers)->first();
        if(is_null($chatRoom)) {
            $chatRoom = new ChatRoom;
            $chatRoom->room_type = 'private';
            $chatRoom->user_ids = $roomMembers;
            $chatRoom->save();
        }

        return view('private-chat.form', compact('chatRoom', 'receiver'));
    }

    public function store(ChatRoom $chatroom)
    {
        $senderId = auth()->user()->id;
        $roomMembers = collect(explode(',', $chatroom->user_ids));
        $roomMembers->forget($roomMembers->search($senderId));
        $receiverId = $roomMembers->first();

        $message = new Message;
        $message->chat_room_id = $chatroom->id;
        $message->sender_id = $senderId;
        $message->message = request('message');
        $message->save();

        $receiver = new Receiver;
        $receiver->message_id = $message->id;
        $receiver->receiver_id = $receiverId;

        if($receiver->save()) {
            $message = Message::with('sender')->find($message->id);
            broadcast(new PrivateMessageEvent($message))->toOthers();
            return $message;
        } else {
            return 'Something went wrong!!';
        }
    }
}
