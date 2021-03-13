<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
 
    // Show All Messages In Admin Area

    public function index()
    {
        $messages       = Message::withTrashed()->paginate(4);
        $auth_user      = Auth::user();
        $users          = User::all();

        return view ('admin.messages.messages')->with([

            'messages'  => $messages,
            'auth_user' => $auth_user,
            'users'     => $users
        ]);
    }

    // Store Messages That Have Been Sent From Guests Or Profile Visitors to Registered USer

    public function store(Request $request)
    {
        $request->validate([

            'message_body'      => 'required|min:10|max:300',
        ]);

        $message                 = new Message();
        $message->message_body   = $request->message_body;
        $name                      = request()->route('name');
        $user                    = User::where('name', $name)->first();
        $message->user_id        = $user->id;

        $message->save();
        return redirect()->back()->with([

            'message_sent' => 'Your message has been sent .. Thank you for your honesty',
            'user'         => $user
        ]);
    }


    // Delete Messages of User (Trashed Message)

    public function destroy($id)
    {
        $message = Message::find($id);
        $message->delete();
        return redirect()->back()->with([
           'message_deleted' => '<b>Message</b> has been deleted',
        ]);
    }


    // Show All Trashed Messages of User

    public function trashedMessages()
    {
        $auth_user = Auth::user();
        $messages  = Message::onlyTrashed()->paginate(4);
        return view('admin.messages.deletedMessages')->with([

            'messages' => $messages,
            'auth_user' => $auth_user,
        ]);
    }

    // Restore Trashed Messages of User

    public function restoreDeletedMessages($id)
    {
        $message = Message::withTrashed()->where('id', $id);
        $message->restore();
        return redirect()->route('trashed.messages')->with([

            'message_restored' => '<b>Message</b> has been restored successfully!'
        ]);
    }

    // Delete Messages Forever For User

    public function deleteMessagesForever($id)
    {
        $message = Message::withTrashed()->where('id', $id);
        $message->forceDelete();
        return redirect()->route('trashed.messages')->with([

            'message_deleted' => '<b>Message</b> has been deleted Forever!!'
        ]);

    }

}
