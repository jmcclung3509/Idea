<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|email|string|max:255',
            'password' => 'required|min:8|string|max:255',
        ]);

        if (! Auth::attempt($attributes)) {
            return back()
                ->withErrors(['password' => 'Invalid credentials'])
                ->withInput();
        }
        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'You are now logged in');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/')->with('success', 'You are now logged out');
    }
}
