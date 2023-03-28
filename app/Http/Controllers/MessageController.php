<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
 
    // Show All Messages In Admin Area

    public function index()
    {
        $messages       = Message::withTrashed()->paginate(10);
        $users          = User::all();

        return view ('admin.messages.index')->with([
            'messages'  => $messages,
            'users'     => $users
        ]);
    }

    // Store Messages That Have Been Sent From Guests Or Profile Visitors to Registered USer

    public function store(StoreMessageRequest $request)
    {
        $userId = User::where('name', request()->route('name'))->first()->id;
        $validatedData = $request->validated();
        Message::create([
            'body' => $validatedData['body'],
            'user_id' => $userId
        ]);

        return redirect()->back()->with([
            'message_sent' => 'Your message has been sent .. Thank you for your honesty',
        ]);
    }


    // Delete Messages of User

    public function destroy($id)
    {
        $message = Message::find($id);
        $message->delete();
        return redirect()->back()->with([
           'message_deleted' => '<b>Message</b> has been deleted',
        ]);
    }


    // Show All Trashed Messages

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
