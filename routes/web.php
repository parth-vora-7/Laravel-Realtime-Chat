<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('users', 'UserController@index')->name('user.list');

Route::get('group-chat', 'GroupChatController@index')->name('group.chat.index');
Route::post('group-chat', 'GroupChatController@store')->name('group.chat.store');

Route::get('private-chat/{chatroom}', 'PrivateChatController@index')->name('private.chat.index');
Route::post('private-chat/{chatroom}', 'PrivateChatController@store')->name('private.chat.store');

Route::get('test', function() {
<<<<<<< HEAD
	$message = App\Models\Message::first();
	dd($message->receivers->first()->receiver_id);
	$message->receivers->pluck('receiver_id')->contains(auth()->user()->id);

	$a = $message->receivers->pluck('receiver_id')->contains(auth()->user()->id);
	dd($a);
=======
	$arr = [3, 1];
	sort($arr);
	dd($arr);
>>>>>>> 19055efaf6541cf31c16a20425946d90b828df02
});
