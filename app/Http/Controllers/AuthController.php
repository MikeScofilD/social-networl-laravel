<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getSignUp()
    {
        return view('auth.signup');
    }

    public function postSignUp(Request $request)
    {
        // dd($request);

        //alpha_dash - Может содержать буквенно-цифровые символы а также тире и подчеркивание

        $this->validate($request, [
            'email' => 'required|unique:users|email|max:255',
            'username' => 'required|unique:users|alpha_dash|max:20',
            'password' => 'required|min:6',
            'gender' => 'required', 'string',
        ]);
        // dd($request);
        User::create([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'gender' => $request->input('gender'),
        ]);

        return redirect()->route('home')->with('info', 'Вы упешкно зарегестрировались!');
    }

    public function getSignIn()
    {
        return view('auth.signin');
    }
    public function postSignIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6',
        ]);
        if (!Auth::attempt($request->only(['email', 'password']), $request->has('remember'))) {
            return redirect()->back()->with('info', 'Не правельный логин или пароль');
        }
        return redirect()->route('home')->with('info', 'Вы вошли на сайта');
        // dd($request);
    }

    public function signOut()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
