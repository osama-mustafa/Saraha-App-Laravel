<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use Illuminate\Routing\RouteGroup;

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

// ROUTES FOR AUTH USER
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

    

    // ROUTES FOR ADMIN
    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'admin.'], function() {

        // Add Admin & Remove Admin
        Route::post('/user/{id}/add-admin', [UserController::class, 'addAdmin'])->name('users.add.admin');
        Route::post('/user/{id}/remove-admin', [UserController::class, 'removeAdmin'])->name('users.remove.admin');
        
        // Block & Unblock users
        Route::post('/user/{user}/block', [UserController::class, 'block'])->name('users.block');
        Route::post('/user/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');
        
        // Restore Deleted Message & Force Delete Message
        Route::post('/user/{message_id}/restore', [MessageController::class, 'restore'])->name('messages.restore');
        Route::delete('/user/{message_id}/forceDelete', [MessageController::class, 'deleteForever'])->name('messages.force.delete'); 

        // Show All Trashed Messages
        Route::get('/deleted-messages', [MessageController::class, 'trashedMessages'])->name('messages.trashed');

        Route::resources([
            'users'     => UserController::class,
            'messages'  => MessageController::class
        ]);
    });
});


// Profile of Users for Guests
Route::get('/profile/{name}', [UserController::class, 'publicProfile'])->name('guest.profile');

// Send Message to Any User (For Guests Only)
Route::post('/profile/{name}/message', [MessageController::class, 'store'])->name('user.profile.message');



    