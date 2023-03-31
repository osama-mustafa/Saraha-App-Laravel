<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{

    // Public profile for each user to receive private messages 

    public function guest($name)
    {
        $user         = User::where('name', $name)->firstOrFail();
        $name         = request()->route('name');

        return view ('profile.guest')->with([
            'user'      => $user,
        ]);

    }

    // Show All Users In Admin Area

    public function index()
    {
        $users      = User::paginate(10);
        return view ('admin.users.index')->with([
            'users'     => $users,
        ]);
    }

    // Edit profile of User

    public function editProfile()
    {
        return view('profile.edit');
    }

    // Update profile


    public function updateProfile(UpdateProfileRequest $request, User $user)
    {
        $validatedData  =  $request->validated();
        $user->name     = $validatedData['name'];
        $user->email    = $validatedData['email'];
        $user->save();

        return redirect()->back()->with([
            'profile_updated' => '<b>Your profile</b> has been updated successfully!'
        ]);
    }

    // Change Password of User

    public function changePassword()
    {
        return view('profile.change-password');
    }

    // Update Password of User

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        if (confirmOldPasswordBeforeUpdateIt($request->password, $user->password)) {
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

    // Show User With Messages Recieved

    public function show()
    {
        $auth_user = Auth::user(); 
        return view('profile.user')->with([

            'auth_user' => $auth_user
        ]);

    }
 
    // Edit User Profile By Admin

    public function editUserByAdmin($id)
    {
        $auth_user  = Auth::user();
        $user       = User::find($id);
        return view ('admin.users.edit')->with([

            'user'      => $user,
            'auth_user' => $auth_user

        ]);
    }


    // Update User Profile By Admin

    public function updateUserByAdmin(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([

            'name'  => [
                'required', 'min:5',
                Rule::unique('users', 'name')->ignore($user->id)
            ],
            'email' => [
                'required', 
                Rule::unique('users', 'email')->ignore($user->id)
            ]
        ]);

        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->save();

        if (!empty($request->input('password')))
        {
            $user->password = Hash::make(trim($request->password));
            $user->save();
        }

        return redirect()->back()->with([
            'profile_updated' => 'Profile of <b>' . $user->name . '</b> has been updated successfully!'
        ]);


    }

    // Delete User

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with([
            'user_deleted' => 'User has been deleted'
        ]);
    }

    // Assign User As Admin

    public function makeAdmin($id)
    {
        $user = User::find($id);
        $user->admin = true;
        $user->update();
        return redirect()->back()->with([
            'admin_message' => '<strong>' . $user->name . ' </strong> is added to Admins'
        ]);
    }

    // Remove User From Admins

    public function removeAdmin($id)
    {
        $user = User::find($id);
        $user->admin = false;
        $user->update();
        return redirect()->back()->with([
            'admin_message' => '<strong>' . $user->name . ' </strong> has been removed from admins'
        ]);
    }
}
