<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auth_user = Auth::user();
        $users     = User::all();
        $messages  = Message::all();
        return view('dashboard')->with([

            'auth_user' => $auth_user,
            'users'     => $users,
            'messages'  => $messages
        ]);
    }
}
