<?php

namespace App\Http\Controllers;

use App\Notifications\EmailChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit',
            ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore(Auth::user())],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $originalEmail = Auth::user()->email;
        Auth::user()->update(array_filter([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ?? Auth::user()->password,
        ]));

        if ($originalEmail !== $request->email) {
            Notification::route('mail', $originalEmail)->notify(new EmailChanged(Auth::user(), $originalEmail));
        }

        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    }
}
