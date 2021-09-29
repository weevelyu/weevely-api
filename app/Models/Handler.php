<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Handler extends Model
{
    static public function isAdmin($user)
    {
        if ($user === null)
            return false;
        else if ($user->role == 'admin')
            return true;
        return false;
    }

    static public function userExists($user_id)
    {
        if (User::find($user_id) === null)
            return false;
        return true;
    }
}
