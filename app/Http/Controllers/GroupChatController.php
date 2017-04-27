<?php

namespace App\Http\Controllers;

use App\GroupChat;
use Illuminate\Http\Request;
use App\Events\GroupMessageEvent;
use App\Events\GroupJoinEvent;

class GroupChatController extends Controller
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

    public function index()
    {
        event(new GroupJoinEvent());
        $chat = GroupChat::with('sender')->get();
    	return view('group-chat.form', compact('chat'));
    }

    public function store()
    {
        $sender = auth()->user()->id;
    	$chat = new GroupChat();
    	$chat->sender_id = $sender;
    	$chat->message = request('message');

    	if($chat->save()) {
            $sender = $chat->sender;
			event(new GroupMessageEvent($chat, $sender));
            //broadcast(new ShippingStatusUpdated($update))->toOthers();
            return 'success';
    	} else {
    		dd('Something went wrong!!');
    	}
    }
}
