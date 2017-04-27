<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomMember extends Model
{
	public $timestamps = false;

	protected $fillable = [
	'chat_room_id', 'user_ids'
	];

	/**
 	* Get the sender of the message
 	*/
 	public function chatRoom()
 	{
 		return $this->belongsTo('App\Models\ChatRoom');
 	}

 	public function getUserIdsAttribute($value)
 	{
 		return unserialize($value);
 	}

 	public function scopeMembers($query)
 	{
 		return $query->where('active', 1);
 	}
}
