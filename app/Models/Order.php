<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property string $id
 * @property string $name
 * @property string $call_number
 * @property string|null $email
 * @property string $status
 * @property Carbon $start_rent
 * @property Carbon $end_rent
 * @property string $Car_series_number
 * @property int $User_id
 * 
 * @property Car $car
 * @property User $user
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'order';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'start_rent' => 'datetime',
		'end_rent' => 'datetime',
		'User_id' => 'int'
	];

	protected $fillable = [
		'name',
		'call_number',
		'email',
		'status',
		'start_rent',
		'end_rent',
		'Car_series_number',
		'User_id'
	];

	public function car()
	{
		return $this->belongsTo(Car::class, 'Car_series_number');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'User_id');
	}

	public function payments()
	{
		return $this->hasMany(Payment::class, 'Order_id');
	}
}
