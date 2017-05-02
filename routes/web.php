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

Route::get('private-chat/{chatroom}', 'PrivateChatController@index')->name('private.chat.index');
Route::post('private-chat/{chatroom}', 'PrivateChatController@store')->name('private.chat.store');
Route::get('fetch-private-chat/{chatroom}/', 'PrivateChatController@get')->name('fetch-private.chat');

Route::get('public-chat', 'PublicChatController@index')->name('public.chat.index');
Route::post('public-chat/{chatroom}', 'PublicChatController@store')->name('public.chat.store');
Route::get('fetch-public-chat/{chatroom}/', 'PublicChatController@get')->name('fetch-public.chat');

Route::get('test', function() {
	$senderId = auth()->user()->id;

	$receiverIds = App\Models\User::where('id', '!=', $senderId)->get(['id'])->pluck('id')->toArray();
	$receiverIds = implode(',', $receiverIds);
	dd($receiverIds);
});
