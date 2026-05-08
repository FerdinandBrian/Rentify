<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'car';

    protected $primaryKey = 'series_number';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'series_number',
        'name',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'Car_series_number', 'series_number');
    }
}
