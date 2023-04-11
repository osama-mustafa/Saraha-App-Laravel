<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Traits\ImageUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    use ImageUpload;


    public function index()
    {
        $users      = User::paginate(10);
        return view ('admin.users.index')->with([
            'users'     => $users,
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $image = $this->handleUploadImage($request);
        User::create([
            'name'      => $validatedData['name'],
            'email'     => $validatedData['email'],
            'password'  => Hash::make(trim($validatedData['password'])),
            'image'     => $image,
        ]);
        return back()->with([
            'user_created' => "User has been created successfully!"
        ]);
    }



    public function show()
    {
        $user = User::with('messages')->find(Auth::id());
        $messages = $user->messages()->latest()->get();
        return view('profile.user')->with(['messages' => $messages]);
    }
 
    public function edit(User $user)
    {
        return view('admin.users.edit')->with([
            'user'      => $user,
        ]);
    }

    public function update(UpdateProfileRequest $request, User $user)
    {
        $validatedData  = $request->validated();
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        if (!empty($request->input('password')))
        {
            $user->update([
                'password' => Hash::make(trim($request->password))
            ]);
        }

        return back()->with([
            'profile_updated' => "Profile of <b>{$user->name}</b> has been updated successfully!"
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with([
            'user_deleted' => 'User has been deleted'
        ]);
    }

    public function addAdmin($id)
    {
        $user = User::find($id);
        $user->is_admin = true;
        $user->update();
        return back()->with([
            'admin_message' => "<b>{$user->name}</b> is added to Admins"
        ]);
    }

    public function removeAdmin($id)
    {
        $user = User::find($id);
        $user->update([
            'is_admin' => false
        ]);
        return back()->with([
            'admin_message' => "<b>{$user->name}</b> has been removed from admins"
        ]);
    }

    public function block(User $user)
    {
        $user->is_blocked = true;
        $user->save();
        return back()->with([
            'admin_message' => "<b>{$user->name}</b> has been blocked, and will not receive any private messages"
        ]);
    }

    public function unblock(User $user)
    {
        $user->is_blocked = false;
        $user->save();
        return back()->with([
            'admin_message' => "<b>{$user->name}</b> has been unblocked, and can receive private messages"
        ]);
    }
}
