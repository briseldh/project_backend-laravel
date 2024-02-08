<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function getUserLikes(Request $request)
    {
        $likes = DB::select('select * from project_backend.post_likes where user_id = :userId', ['userId' => $request->user()->id]);

        return response()->json(['likes' => $likes], 200);
    }

    public function getLikeCount(Request $request)
    {
        $likes = Like::all()->count();

        return response()->json(['likes' => $likes], 200);
    }

    public function like(Post $post)
    {
        $liker = auth()->user(); // Liker in this case is the logged in user

        foreach ($liker->likes as $likeCombination) {

            if ($likeCombination->pivot->post_id == $post->id) {

                return response()->json(['message' => 'This post is liked alredy!'], 400);
            }
        }

        $liker->likes()->attach($post->id);

        return response()->json(['message' => 'The post ' . $post->id . ' is liked by ' . $liker->name], 200);
    }

    public function dislike(Post $post)
    {
        $liker = auth()->user();

        $liker->likes()->detach($post->id);

        return response()->json(['message' => 'The post ' . $post->id . ' is disliked by ' . $liker->name], 200);
    }
}
