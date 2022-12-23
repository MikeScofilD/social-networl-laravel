<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function getIndex()
    {
        $friends = Auth::user()->friends();
        $friendRequest = Auth::user()->friendRequests();
        return view('friends.index', compact('friends', 'friendRequest'));
    }
}
