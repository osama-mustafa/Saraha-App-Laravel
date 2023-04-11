<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;

class ProfileController extends Controller
{


    public function publicProfile($name)
    {
        $user         = User::where('name', $name)->firstOrFail();
        $name         = request()->route('name');

        return view ('profile.guest')->with([
            'user'      => $user,
        ]);

    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(UpdateProfileRequest $request, User $user)
    {
        $validatedData  =  $request->validated();
        $user->name     = $validatedData['name'];
        $user->email    = $validatedData['email'];

        if ($request->has('image')) {
            $image = $this->handleUploadImage($request);
            $user->image = $image;
        }

        $user->save();

        return back()->with([
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

}
