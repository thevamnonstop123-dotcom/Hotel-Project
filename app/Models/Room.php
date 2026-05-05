<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_number', 'price', 'bed_type', 'has_wifi',];


    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }
}
