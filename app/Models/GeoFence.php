<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class GeoFence extends Model
{
    use HasFactory;
    protected $fillable = ['device_id', 'coordinates'];

    public function geofences()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
