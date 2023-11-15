<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    // public function before(User $user)
    // {
    //     // TODO: Check if the user is an Admin.
    // }

    public function insert(User $user)
    {
        // Only someone who is loged in can comment.
        return $user !== null ?
            Response::allow('CommentPolicy - insert - allowed') :
            Response::deny('CommentPolicy - insert - denied');
    }

    public function update(User $user, Comment $comment)
    {
        // Only the person who created a comment can update it.
        return $user->id === $comment->user_id ?
            Response::allow('CommentPolicy - update - allowed') :
            Response::deny('CommentPolicy - update - denied');
    }

    public function delete(User $user, Comment $comment)
    {
        // Only the person who created a comment can delete it.
        return $user->id === $comment->user_id ?
            Response::allow('CommentPolicy - delete - allowed') :
            Response::deny('CommentPolicy - delete - denied');
    }

    public function getById(User $user)
    {
        // Only the person who created a comment can get the comment data.
        return $user->id !== null ?
            Response::allow('CommentPolicy - getById - allowed') :
            Response::deny('CommentPolicy - getById - denied');
    }
}
