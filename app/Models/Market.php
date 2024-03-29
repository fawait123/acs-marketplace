<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function owner()
    {
        return $this->belongsTo(Owner::class,'owner_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class,'market_id');
    }
}
