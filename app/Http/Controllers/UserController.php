<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'min:1|max:50',
            'userid' => 'required|max:4',
        ]);
        $user = User::findOrFail($request->userid);
        if ($request->password == '') {
            $password = $user->password;
        } else {
            $password = Hash::make($request->password);
        }
        if ($request->hasFile('photo')) {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('photo')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs("public/user", $fileNameToStore);
        }
        // Else add a dummy image
        else {
            $fileNameToStore = $user->photo;
        }

        $user->name = $request->name;

        $user->password = $password;

        $user->key = $request->key;


        $user->photo  = $fileNameToStore;

        if ($user->save()) {
            return redirect()->back()->with('success', __('Profile Updated'));
        } else {
            return redirect()->back()->with('error', __('Profile Not Updated'));
        }
    }
}
