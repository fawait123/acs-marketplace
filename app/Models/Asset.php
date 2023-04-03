<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(DetailAsset::class,'asset_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class,'type_id');
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class,'machine_id');
    }
}
