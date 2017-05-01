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
Route::get('fetch-private-chat/{chatroom}/', 'PrivateChatController@get')->name('fetch-private.chat');

Route::get('test', function() {
	$p = App\Models\ChatRoom::with('messages.sender')->find(1);
	dd($p);
});
