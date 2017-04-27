<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
	protected $fillable = [
	'room_type', 'user_ids'
	];

	/**
 	* Get the sender of the message
 	*/
 	public function sender()
 	{
 		return $this->hasOne('App\Models\User', 'sender_id');
 	}
 }
