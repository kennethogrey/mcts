<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class Location extends Model
{
    use HasFactory;
    protected $fillable = ['device_id', 'longitude','latitude'];

    public function coordinates()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
