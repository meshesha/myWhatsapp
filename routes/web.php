<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });
//Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
//Route::post('/', [App\Http\Controllers\HomeController::class, 'index']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::resource('wpp', App\Http\Controllers\WppconnectController::class);
Route::get('wpp', [App\Http\Controllers\WppconnectController::class, 'index'])->name('wpp.index');
Route::post('wpp/getqrcode', [App\Http\Controllers\WppconnectController::class, 'getQrCode'])->name('wpp.getqrcode');

Route::get('wpp/getallsession', [App\Http\Controllers\WppconnectController::class, 'getAllSession'])->name('wpp.getallsession');
Route::get('wpp/startallsession', [App\Http\Controllers\WppconnectController::class, 'startAllSession'])->name('wpp.startallsession');
Route::get('wpp/startsession/{session}', [App\Http\Controllers\WppconnectController::class, 'startSession'])->name('wpp.startsession');
Route::get('wpp/closesession/{session}', [App\Http\Controllers\WppconnectController::class, 'closeSession'])->name('wpp.closesession');

Route::get('wpp/chat', [App\Http\Controllers\WppconnectController::class, 'chat'])->name('wpp.chat');
//Route::post('wpp/chatajax', [App\Http\Controllers\WppconnectController::class, 'getAllChatsAjax'])->name('wpp.chatajax');
Route::post('wpp/chatmsg', [App\Http\Controllers\WppconnectController::class, 'getAllMessagesInChat'])->name('wpp.chatmsg');
//Route::post('wpp/earlierchatmsg', [App\Http\Controllers\WppconnectController::class, 'earlierMessages'])->name('wpp.earlierchatmsg');
Route::post('wpp/sendmsg', [App\Http\Controllers\WppconnectController::class, 'sendMessage'])->name('wpp.sendmsg');
Route::post('wpp/sendfile', [App\Http\Controllers\WppconnectController::class, 'sendFile'])->name('wpp.sendfile');
Route::post('wpp/forwordmsg', [App\Http\Controllers\WppconnectController::class, 'forwordMessage'])->name('wpp.forwordmsg');
Route::get('wpp/msg/{id}', [App\Http\Controllers\WppconnectController::class, 'messageById'])->name('wpp.msg');

//Route::post('wpp/setseen', [App\Http\Controllers\WppconnectController::class, 'setSeenMessage'])->name('wpp.setseen');

Route::get('wpp/contact', [App\Http\Controllers\WppconnectController::class, 'getAllContactsAjax'])->name('wpp.contact');
Route::get('wpp/contactpic/{userid}', [App\Http\Controllers\WppconnectController::class, 'getProfileImgAjax'])->name('wpp.contactpic');

Route::post('pond/upload', [App\Http\Controllers\FilePond::class, 'store'])->name('pond.upload');