<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user'];

    public function userz()
    {
        return $this->belongsTo(User::class,'user');
    }

    public function geofences()
    {
        return $this->hasOne(GeoFence::class);
    }

    public function coordinates()
    {
        return $this->hasOne(Location::class);
    }
}

