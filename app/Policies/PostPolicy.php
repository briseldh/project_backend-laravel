<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{

    // public function before(User $user)
    // {
    //     // TODO: Check if the user is an Admin.
    // }

    public function insert(User $user)
    {
        // Only someone who is loged in can post.
        return $user !== null ?
            Response::allow('PostPolicy - insert - allowed') :
            Response::deny('PostPolicy - insert - denied');
    }

    public function update(User $user, Post $post)
    {
        // Only the person who created a post can update it.
        return $user->id === $post->user_id ?
            Response::allow('PostPolicy - update - allowed') :
            Response::deny('PostPolicy - update - denied');
    }

    public function delete(User $user, Post $post)
    {
        // Only the person who created a post can delete it.
        return $user->id === $post->user_id ?
            Response::allow('PostPolicy - delete - allowed') :
            Response::deny('PostPolicy - delete - denied');
    }

    public function getById(User $user, Post $post)
    {
        // Only the person who created a post can get the post data.
        return $user->id === $post->user_id ?
            Response::allow('PostPolicy - getById - allowed') :
            Response::deny('PostPolicy - getById - denied');
    }

    public function getAll()
    {
        return Response::allow('PostPolicy - getAll - allowed');
        // return $user->id !== null ? Response::allow('PostPolicy - getAll - allowed') : Response::deny('PostPolicy - getAll - denied');
    }

    public function uploadFile(User $user, Post $post)
    {
        return $user->id === $post->user_id ?
            Response::allow('PostPolicy - uploadFile - allowed') :
            Response::deny('PostPolicy - uploadFile - denied');
    }
}
