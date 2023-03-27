<?php

namespace App\Helpers;
use App\Models\Notification as ModelNotification;


class Notification {

    public static function get()
    {
        if(auth()->user()){
            return ModelNotification::where('to_user',auth()->user()->id)->where('is_read',0)->get();
        }

        return [];
    }
}
