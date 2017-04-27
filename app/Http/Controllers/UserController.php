<?php

namespace App\Http\Controllers;

use App\PrivateChat;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
    	$users = User::where('id', '!=', auth()->user()->id)->get();
    	return view('user.list', compact('users'));
    }
}
