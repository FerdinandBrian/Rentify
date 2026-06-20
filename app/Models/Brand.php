<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|Car[] $cars
 *
 * @package App\Models
 */
class Brand extends Model
{
	protected $table = 'brand';
	public $incrementing = true;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'id',
		'name'
	];

	public function cars()
	{
		return $this->hasMany(Car::class, 'brand_id');
	}
}
