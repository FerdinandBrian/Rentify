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
 * @property int $Brand_id
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

	protected $casts = [
		'price' => 'float',
		'year' => 'datetime',
		'Brand_id' => 'int'
	];

	protected $fillable = [
		'name',
		'price',
		'type',
		'year',
		'status',
		'Brand_id'
	];

	public function brand()
	{
		return $this->belongsTo(Brand::class, 'Brand_id');
	}

	public function feedback()
	{
		return $this->hasMany(Feedback::class, 'Car_series_number');
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'Car_series_number');
	}
}
