<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Models\User;

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
    return view('homepage');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    // Dashboard For Registered Users
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile of Each User With Messages Recieved
    Route::get('/user/messages', [UserController::class, 'show'])->name('user.profile');

    // Delete Message (For Users & Admins)
    Route::delete('/user/{message_id}/message/delete', [MessageController::class, 'destroy'])->name('user.delete.message');

    // Show All Trashed (Deleted) Messages Of Each User
    // Route::get('/user/{id}/deleted-messages', [MessageController::class, 'trashedMessages'])->name('trashed.messages');

    // Edit & Update User
    Route::get('/profile/{id}/edit', [UserController::class, 'editYourProfile'])->name('edit.profile');
    Route::post('/profile/{id}/update', [UserController::class, 'updateYourProfile'])->name('update.profile');

    // Change Password of User
    Route::get('/profile/{id}/changepassword', [UserController::class, 'changePassword'])->name('change.password');
    Route::post('profile/{id}/updatepassword', [UserController::class, 'updatePassword'])->name('update.password');

});


// Profile of Users for Guests
// Route::get('/profile/{id}', [UserController::class, 'guest'])->name('guest.profile');

Route::get('/profile/{name}', [UserController::class, 'guest'])->name('guest.profile');


// Send Message to Any User (For Guests Only)
// Route::post('/profile/{id}/message', [MessageController::class, 'store'])->name('user.profile.message');

Route::post('/profile/{name}/message', [MessageController::class, 'store'])->name('user.profile.message');



// ROUTES FOR ADMIN

Route::middleware(['auth', 'admin'])->group(function () {
    
    // Show All Users
    Route::get('/users', [UserController::class, 'index'])->name('users');

    // Show All Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');

    // Show All Trashed (Deleted) Messages
    Route::get('/deleted-messages', [MessageController::class, 'trashedMessages'])->name('trashed.messages');

    // Soft Deletes For Messages
    Route::post('/user/{message_id}/restore', [MessageController::class, 'restoreDeletedMessages'])->name('restore.messages');
    Route::delete('/user/{message_id}/forceDelete', [MessageController::class, 'deleteMessagesForever'])->name('force.delete.messages');        

    // Delete User
    Route::delete('/user/{id}/delete', [UserController::class, 'destroy'])->name('delete.user');

    // Make User As Admin & Remove User From Admin
    Route::post('/user/{id}/admin', [UserController::class, 'makeAdmin'])->name('make.admin');
    Route::post('/user/{id}/notadmin', [UserController::class, 'removeAdmin'])->name('remove.admin');

    // Edit Profile Users For Admins
    Route::get('/user/{id}/edit', [UserController::class, 'editUserByAdmin'])->name('edit.user');
    Route::post('/user/{id}/update', [UserController::class, 'updateUserByAdmin'])->name('update.user');

});
    