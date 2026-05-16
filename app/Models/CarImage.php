<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    protected $fillable = [
        'image_path',
        'is_primary',
    ];

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_car_image', 'car_image_id', 'car_series_number');
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }
}
