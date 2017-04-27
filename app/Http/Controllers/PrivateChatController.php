<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PrivateMessageEvent;
use App\Models\User;
use App\Models\ChatRoom;
use App\Models\Message;
<<<<<<< HEAD
use App\Models\Receiver;
=======
use App\Models\RoomMember;
>>>>>>> 19055efaf6541cf31c16a20425946d90b828df02

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

	public function index($receiverId)
    {
<<<<<<< HEAD
        $senderId = auth()->user()->id;
        $roomMembers = ['sender' => $senderId, 'receivers' => $receiverId];
        sort($roomMembers);
        $roomMembers = implode($roomMembers, ',');

        $chatroom = ChatRoom::where([
            'room_type' => 'private',
            'user_ids' => $roomMembers
            ])
        ->first();

        if(!$chatroom) {
            $chatroom = new ChatRoom;
            $chatroom->room_type = 'private';
            $chatroom->user_ids = $roomMembers;
            $chatroom->save();            
        }

        $chat = Message::where('chat_room_id', $chatroom->id)->get();

        return view('private-chat.form', compact('chat', 'chatroom'));
=======
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

        $messages = Message::where('chat_room_id', $chatRoom->id)->get();
        return view('private-chat.form', compact('chatRoom', 'messages'));
>>>>>>> 19055efaf6541cf31c16a20425946d90b828df02
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
            event(new PrivateMessageEvent($message));
            //broadcast(new ShippingStatusUpdated($update))->toOthers();
            return $message->room_id;
        } else {
            dd('Something went wrong!!');
        }
    }
}
