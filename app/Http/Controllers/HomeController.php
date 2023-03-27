<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users     = User::all();
        $messages  = Message::all();
        return view('dashboard')->with([
            'users'     => $users,
            'messages'  => $messages
        ]);
    }
}
