<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // return response()->json(["message" => "Login successful"], 200);

        // $request->validate([
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', Password::min(8)
        //         ->letters()
        //         ->mixedCase()
        //         ->numbers()
        //         ->symbols()
        //         ->uncompromised()]
        // ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            $error = ['root' => ['Invalid credentials']];

            return response()->json(['errors' => $error], 401);
        }

        //Alternative
        // if (!Auth::attempt($request->only('email', 'password'))) {
        //     $error = ['errors' => ['root' => ['Invalid credentials']]];

        //     return response()->json(status: 401, data: $error);
        // }

        $request->session()->regenerate();

        $user = User::where('email', $request->input('email'))->firstOrFail();

        return response()->json(['message' => 'Login successful', 'userData' => $user], 200);
    }
}
