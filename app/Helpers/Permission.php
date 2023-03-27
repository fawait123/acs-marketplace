<?php

namespace App\Helpers;
use App\Models\User;


class Permission {

    public static function access()
    {
        if(auth()->user()){
            $user = User::find(auth()->user()->id);
            return $user->getAllPermissions()->pluck('name');
        }

        return [];
    }
}
