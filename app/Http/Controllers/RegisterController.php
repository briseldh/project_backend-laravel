<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'min:5', 'max:32'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string']
        ]);

        $user = User::create([
            'name' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            // 'role' => "user"
        ]);

        // TODO:
        // Find a way to refresh the registrated user before logging him in.

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json(['message' => 'Register successful', 'userData' => $user], 201);
    }
}
