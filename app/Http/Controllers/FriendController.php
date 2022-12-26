<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function getIndex()
    {
        $friends = Auth::user()->friends();
        $friendRequest = Auth::user()->friendRequests();
        // dd($friendRequest);
        return view('friends.index', compact('friends', 'friendRequest'));
    }

    public function getAdd($username)
    {
        $friend = User::where('username', $username)->first();
        // dd($friend);
        if (!$friend) {
            return redirect()->route('home')->with('info', 'Пользователь не найден');
        }
        if(Auth::user()->id === $friend->id)
        {
            return redirect()->route('home');
        }

        if (Auth::user()->hasFriendRequestsPending($friend) || $friend->hasFriendRequestsPending(Auth::user())) {
            return redirect()->route('profile.index', ['username' => $friend->username])->with('info', 'Пользователю отправлен запрос в друзья');
        }

        if (Auth::user()->isFriendWith($friend)) {
            return redirect()->route('profile.index', ['username' => $friend->username])->with('info', 'Пользователь уже в друзьях');
        }

        Auth::user()->addFriend($friend);

        return redirect()->route('profile.index', ['username' => $username])->with('info', 'Пользователю отправлен запрос в друзья');
    }

    public function getAccept($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return redirect()->route('home')->with('info', 'Пользователь не найден');
        }
        if (!Auth::user()->hasFriendRequestReceived($user) ) {
           return redirect()->route('home');
        }

        Auth::user()->acceptFriendRequest($user);

        return redirect()->route('profile.index', ['username' => $username])->with('info', 'Запрос в друзья принят');
    }

    public function postDelete($username)
    {
        $user = User::where('username', $username)->first();
        // dd($user->username);
        if(!Auth::user()->isFriendWith($user))
        {
            return redirect()->back();
        }

        Auth::user()->deleteFriend($user);

        return redirect()->back()->with('info', 'Друг удален');
    }
}
