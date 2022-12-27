<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $statuses = Status::where(function ($query) {
                return $query->where('user_id', Auth::user()->id)
                    ->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
            })->orderBy('created_at', 'desc')->paginate(1);

            return view('timeline.index', compact('statuses'));
        }
        return view('home');
    }
}
