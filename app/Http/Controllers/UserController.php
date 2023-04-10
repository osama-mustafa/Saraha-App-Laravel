<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function publicProfile($name)
    {
        $user         = User::where('name', $name)->firstOrFail();
        $name         = request()->route('name');

        return view ('profile.guest')->with([
            'user'      => $user,
        ]);

    }

    public function index()
    {
        $users      = User::paginate(10);
        return view ('admin.users.index')->with([
            'users'     => $users,
        ]);
    }

    public function editProfile()
    {
        return view('profile.edit');
    }

    public function updateProfile(UpdateProfileRequest $request, User $user)
    {
        $validatedData  =  $request->validated();
        $user->name     = $validatedData['name'];
        $user->email    = $validatedData['email'];

        if ($request->has('image')) {
            $image = handleUploadImage($request);
            $user->image = $image;
        }

        $user->save();

        return redirect()->back()->with([
            'profile_updated' => '<b>Your profile</b> has been updated successfully!'
        ]);
    }

    public function changePassword()
    {
        return view('profile.change-password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        if (isUserEnterOldPasswordCorrectly($request->password, $user->password)) {
            $validatedData = $request->validated();
            $user->password = Hash::make($validatedData['newpassword']);
            $user->save();
            return redirect()->back()->with([
                'password_updated' => 'Your Password has been updated successfully!'
            ]);
        } else {
            return redirect()->route('change.password')->with([
                'incorrect_password' => 'Current Password Is Incorrect'
            ]);
        }
    }

    public function show()
    {
        return view('profile.user');
    }
 
    public function edit(User $user)
    {
        return view ('admin.users.edit')->with([
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

        return redirect()->back()->with([
            'profile_updated' => "Profile of <b>{$user->name}</b> has been updated successfully!"
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with([
            'user_deleted' => 'User has been deleted'
        ]);
    }

    public function makeAdmin($id)
    {
        $user = User::find($id);
        $user->is_admin = true;
        $user->update();
        return redirect()->back()->with([
            'admin_message' => "<b>{$user->name}</b> is added to Admins"
        ]);
    }

    public function removeAdmin($id)
    {
        $user = User::find($id);
        $user->update([
            'is_admin' => false
        ]);
        return redirect()->back()->with([
            'admin_message' => "<b>{$user->name}</b> has been removed from admins"
        ]);
    }

    public function block(User $user)
    {
        $user->is_blocked = true;
        $user->save();
        return redirect()->back()->with([
            'admin_message' => "<b>{$user->name}</b> has been blocked, and will not receive any private messages"
        ]);
    }

    public function unblock(User $user)
    {
        $user->is_blocked = false;
        $user->save();
        return redirect()->back()->with([
            'admin_message' => "<b>{$user->name}</b> has been unblocked, and can receive private messages"
        ]);
    }
}
