<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class,'machine_id');
    }
}
