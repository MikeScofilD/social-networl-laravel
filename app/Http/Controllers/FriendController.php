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
        return view('friends.index', compact('friends', 'friendRequest'));
    }

    public function getAdd($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->route('home')->with('info', 'Пользователь не найден');
        }
        if(Auth::user()->id === $user->id)
        {
            return redirect()->route('home');
        }

        if (Auth::user()->hasFriendRequestsPending($user) || $user->hasFriendRequestsPending(Auth::user())) {
            return redirect()->route('profile.index', ['username' => $user->username])->with('info', 'Пользователю отправлен запрос в друзья');
        }

        if (Auth::user()->isFriendWith($user)) {
            return redirect()->route('profile.index', ['username' => $user->username])->with('info', 'Пользователь уже в друзьях');
        }

        Auth::user()->addFriend($user);

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
}
