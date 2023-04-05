<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

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

    // Profile of Each User With Recieved Messages 
    Route::get('/user/messages', [UserController::class, 'show'])->name('user.profile');

    // Delete Message (For Users & Admins)
    Route::delete('/user/{message}/message/delete', [MessageController::class, 'destroy'])->name('user.delete.message');

    // Edit & Update User
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('edit.profile');
    Route::post('/profile/{user}/update', [UserController::class, 'updateProfile'])->name('update.profile');

    // Change Password of User
    Route::get('/profile/change-password', [UserController::class, 'changePassword'])->name('change.password');
    Route::post('profile/{id}/update-password', [UserController::class, 'updatePassword'])->name('update.password');

});


// Profile of Users for Guests
Route::get('/profile/{name}', [UserController::class, 'guest'])->name('guest.profile');

// Send Message to Any User (For Guests Only)
Route::post('/profile/{name}/message', [MessageController::class, 'store'])->name('user.profile.message');



// ROUTES FOR ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Show All Users
    Route::get('/users', [UserController::class, 'index'])->name('users');

    // Show All Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');

    // Show All Trashed Messages
    Route::get('/deleted-messages', [MessageController::class, 'trashedMessages'])->name('trashed.messages');

    // Restore Deleted Message & Force Delete Message
    Route::post('/user/{message_id}/restore', [MessageController::class, 'restoreDeletedMessages'])->name('restore.messages');
    Route::delete('/user/{message_id}/forceDelete', [MessageController::class, 'deleteMessagesForever'])->name('force.delete.messages');        

    // Delete User
    Route::delete('/user/{user}/delete', [UserController::class, 'destroy'])->name('delete.user');

    // Make User As Admin & Remove User From Admin
    Route::post('/user/{id}/admin', [UserController::class, 'makeAdmin'])->name('make.admin');
    Route::post('/user/{id}/notadmin', [UserController::class, 'removeAdmin'])->name('remove.admin');

    // Edit User
    Route::get('/user/{user}/edit', [UserController::class, 'editUser'])->name('edit.user');
    Route::post('/user/{user}/update', [UserController::class, 'updateUser'])->name('update.user');

    // Block & Unblock users
    Route::post('/user/{user}/block', [UserController::class, 'block'])->name('block.admin');
    Route::post('/user/{user}/unblock', [UserController::class, 'unblock'])->name('unblock.admin');
    

});
    