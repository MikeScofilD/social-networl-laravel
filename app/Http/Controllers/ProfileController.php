<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();
        // dd($user);
        if (!$user) {
            abort(404);
        }
        return view('profile.index', compact('user'));
    }
}
