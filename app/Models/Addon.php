<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Addon
 * 
 * @property int $id
 * @property string $name
 * @property float|null $price_per_unit
 * @property float|null $price_per_day
 * 
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class Addon extends Model
{
	protected $table = 'addon';
	public $timestamps = false;

	protected $casts = [
		'price_per_unit' => 'float',
		'price_per_day' => 'float'
	];

	protected $fillable = [
		'name',
		'price_per_unit',
		'price_per_day'
	];

	public function payments()
	{
		return $this->belongsToMany(Payment::class, 'addon_payment', 'addon_id', 'payment_id')
					->withPivot('total_price');
	}
}
