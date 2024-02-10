<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $profilePics = $user->profilePic;
        $uploads = DB::select('select * from project_backend.post_images where user_id = :userId', ['userId' => $request->user()->id]);

        // $user = User::with('posts', 'comments')->get();
        // $posts = Post::with('file')->get();


        return response()->json(['message' => 'GetUserData successful', 'userData' => $user, 'userUploads' => $uploads], 200);
    }

    public function getUserById(string $id)
    {
        $user = User::find($id);

        return response()->json(['message' => 'GetUserById successful', 'userData' => $user], 200);
    }
}
