<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class UserController extends Controller
{

    public function guest($id)
    {
        $auth_user  = Auth::user();
        $id         = request()->route('id');
        $user       = User::where('id', $id)->first();
        $username   = $user->name;

        return view ('users.guest')->with([

            'username'  => $username,
            'user'      => $user,
            'auth_user' => $auth_user
        ]);

    }

    public function index()
    {
        $auth_user  = Auth::user();
        $users      = User::paginate(5);
        return view ('admin.users.index')->with([

            'users'     => $users,
            'auth_user' => $auth_user
        ]);
    }

    public function editYourProfile($id)
    {
        $id         = Auth::id();
        $auth_user  = User::where('id', $id)->first();
        return view('users.edit')->With([

            'auth_user' => $auth_user,
         ]); 

    }

    public function updateYourProfile(Request $request, $id)
    {

        $id        = Auth::id();
        $auth_user = User::where('id', $id)->first();
        $validatedData =  $request->validate([

            'name'  => 'required|min:5|max:255|string',
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($auth_user->id)
            ]
        ]);

        $auth_user->name  = $validatedData['name'];
        $auth_user->email = $validatedData['email'];
        $auth_user->save();

        return redirect()->back()->with([

            'profile_updated' => 'Your profile has been updated successfully!'

        ]);
    }

    public function changePassword($id)
    {
        $id = Auth::id();
        $auth_user = User::where('id', $id)->first();
        return view('users.changePassword')->with([

            'auth_user' => $auth_user

        ]);
    }

    public function updatePassword(Request $request, $id)
    {
        $id         = Auth::id();
        $auth_user  = User::where('id', $id)->first();
        $request->validate([

            'password'    => 'required',
            'newpassword' => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($request->password, $auth_user->password))
        {
            return redirect()->route('change.password', $id)->with([

                'incorrect_password' => 'Current Password Is Incorrect'
            ]);
        }
        else 
        {
            $auth_user->password = Hash::make($request->newpassword);
            $auth_user->save();
            return redirect()->back()->with([

                'password_updated' => 'Your Password has been updated successfully!'
            ]);
        }
    }


    public function show($id)
    {
        // $id        = Auth::id();
        $user      = User::findOrFail($id);
        $auth_user = Auth::user(); 
        $profiles  = User::find(request()->route('id'));
        return view('users.user')->with([

            'user'      => $user,
            'profiles'  => $profiles,
            'auth_user' => $auth_user
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editUserByAdmin($id)
    {
        $auth_user  = Auth::user();
        $user       = User::find($id);
        return view ('admin.users.edit')->with([

            'user'      => $user,
            'auth_user' => $auth_user

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUserByAdmin(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate([

            'name'  => 'required|string|min:5|max:255',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with([
            'user_deleted' => 'User has been deleted'
        ]);
    }

    public function makeAdmin($id)
    {
        $user = User::find($id);
        $user->admin = true;
        $user->update();
        return redirect()->back()->with([
            'admin_message' => '<strong>' . $user->name . ' </strong> is added to Admins'
        ]);
    }

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
