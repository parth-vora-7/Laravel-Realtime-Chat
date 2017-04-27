<?php

namespace App\Models;

use App\Models\User;
use App\Models\Receiver;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function sender() {
    	return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function receivers() {
    	return $this->hasMany(Receiver::class);
    }
}
