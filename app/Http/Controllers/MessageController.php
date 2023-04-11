<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        $messages       = Message::latest()->paginate(10);
        $users          = User::all();

        return view('admin.messages.index')->with([
            'messages'  => $messages,
            'users'     => $users
        ]);
    }

    public function store(StoreMessageRequest $request)
    {
        $user = User::where('name', request()->route('name'))->first();
        $user->messages()->create($request->validated());
        return back()->with([
            'message_sent' => 'Your message has been sent, Thank you for your honesty',
        ]);
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return back()->with([
           'message_deleted' => '<b>Message</b> has been deleted',
        ]);
    }

    public function trashedMessages()
    {
        $messages  = Message::onlyTrashed()->paginate(8);
        return view('admin.messages.deleted-messages')->with([
            'messages' => $messages,
        ]);
    }

    public function restore($id)
    {
        $message = Message::withTrashed()->where('id', $id);
        $message->restore();
        return redirect()->route('admin.messages.trashed')->with([
            'message_restored' => '<b>Message</b> has been restored successfully!'
        ]);
    }

    public function deleteForever($id)
    {
        $message = Message::withTrashed()->where('id', $id);
        $message->forceDelete();
        return redirect()->route('admin.messages.trashed')->with([
            'message_deleted' => '<b>Message</b> has been deleted Forever!!'
        ]);
    }
}
