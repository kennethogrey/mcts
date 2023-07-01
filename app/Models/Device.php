<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Geofence;
use App\Models\Location;

class Device extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user'];

    protected $casts = [
        'updated_at' => 'datetime',
    ];


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

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('user', 'like', $term);
        });
    }
}

