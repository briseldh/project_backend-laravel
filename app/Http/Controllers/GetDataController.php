<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GetDataController extends Controller
{
    public function getUserData(Request $request)
    {
        //Todo return the asked data back

        // if (!Auth::check($id)) {
        //     return response()->json(['message' => 'No acces to the user data. Log in first.'], 403);
        // }

        // $user = User::find($id);
        // $posts = $user->posts;

        $user = $request->user();
        $posts = $user->posts;
        $comments = $user->comments;



        return response()->json(['message' => 'GetUserData successful', 'userData' => $user], 200);
    }
}
