<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Car
 *
 * @property string $series_number
 * @property string $name
 * @property float $price
 * @property string $type
 * @property Carbon|null $year
 * @property string $status
 * @property int $brand_id
 *
 * @property Brand $brand
 * @property Collection|Feedback[] $feedback
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class Car extends Model
{
    protected $table = 'car';
    protected $primaryKey = 'series_number';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $casts = [
        'price' => 'float',
        'year' => 'datetime',
        'brand_id' => 'int',
    ];

    protected $fillable = [
        'series_number',
        'name',
        'price',
        'type',
        'year',
        'status',
        'is_electric',
        'brand_id',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'Car_series_number');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'Car_series_number', 'series_number');
    }

    public function images()
    {
        return $this->belongsToMany(CarImage::class, 'car_car_image', 'car_series_number', 'car_image_id')
            ->withTimestamps();
    }

    public function getPrimaryImagePathAttribute(): string
    {
        $images = $this->relationLoaded('images')
            ? $this->images
            : $this->images()->get();

        return optional($images->firstWhere('is_primary', true) ?? $images->first())->image_path
            ?? 'assets/img/examples/product1.jpg';
    }
}
