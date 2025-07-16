<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
{
    return view('profilepage');
}

public function update(Request $request)
{
    $request->validate(['name' => 'required', 'email' => 'required|email']);
    Auth::user()->update($request->only('name', 'email'));
    return back()->with('success', 'Profile updated successfully.');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|confirmed|min:6',
    ]);

    if (!Hash::check($request->current_password, Auth::user()->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    Auth::user()->update(['password' => Hash::make($request->new_password)]);
    return back()->with('success', 'Password updated successfully.');
}

}
