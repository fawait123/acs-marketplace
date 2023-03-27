<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function userFrom()
    {
        return $this->belongsTo(User::class,'from_user');
    }

    public function userTo()
    {
        return $this->belongsTo(User::class,'to_user');
    }
}
