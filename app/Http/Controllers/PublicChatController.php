<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\Receiver;
use App\Events\PublicMessageEvent;
use App\Events\RoomEvents;

class PublicChatController extends Controller
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

    public function index()
    {
    	$chatRoom = ChatRoom::where('room_type', 'public')->first();
    	if(is_null($chatRoom)) {
    		$chatRoom = new ChatRoom;
    		$chatRoom->room_type = 'public';
    		$chatRoom->save();
    	}
        broadcast(new RoomEvents($chatRoom))->toOthers();
    	return view('public-chat.form', compact('chatRoom'));
    }

    public function store(ChatRoom $chatroom)
    {
    	$senderId = auth()->user()->id;

    	$receiverIds = User::where('id', '!=', $senderId)->get(['id'])->pluck('id')->toArray();

    	$message = new Message;
    	$message->chat_room_id = $chatroom->id;
    	$message->sender_id = $senderId;
    	$message->message = request('message');
    	$message->save();

    	foreach($receiverIds as $receiverId) {
    		$receiver = new Receiver;
    		$receiver->message_id = $message->id;
    		$receiver->receiver_id = $receiverId;
    		$receiver->save();
    	}
    	
    	$message = Message::with('sender')->find($message->id);
    	broadcast(new PublicMessageEvent($message))->toOthers();
    	return $message;
    }
}
