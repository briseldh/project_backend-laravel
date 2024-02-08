<?php

namespace App\Policies;

use App\Models\ProfilePicUpload;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProfilePicPolicy
{
    public function insert(User $user)
    {
        // Only someone who is loged in can add a profile pic.
        return $user !== null ?
            Response::allow('ProfilePicPolicy - insert - allowed') :
            Response::deny('ProfilePicPolicy - insert - denied');
    }

    public function update(User $user, ProfilePicUpload $profilePic)
    {
        // Only the person who has a profile pic can change/update it.
        return $user->id === $profilePic->user_id ?
            Response::allow('ProfilePicPolicy - update - allowed') :
            Response::deny('ProfilePicPolicy - update - denied');
    }

    public function delete(User $user, ProfilePicUpload $profilePic)
    {
        // Only the person who added a profile pic can delete/remove it.
        return $user->id === $profilePic->user_id ?
            Response::allow('ProfilePicPolicy - delete - allowed') :
            Response::deny('ProfilePicPolicy - delete - denied');
    }

    public function getById(User $user, ProfilePicUpload $profilePic)
    {
        // Only the person who added a profile pic can get that profile pic data.
        return $user->id === $profilePic->user_id ?
            Response::allow('ProfilePicPolicy - getById - allowed') :
            Response::deny('ProfilePicPolicy - getById - denied');
    }

    public function getAll()
    {
        return Response::allow('PostPolicy - getAll - allowed');
    }
}
