<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 * 
 * @property int $id
 * @property string $star
 * @property string $message
 * @property string $Car_series_number
 * @property int $User_id
 * 
 * @property Car $car
 * @property User $user
 *
 * @package App\Models
 */
class Feedback extends Model
{
	protected $table = 'feedback';
	public $timestamps = false;

	protected $casts = [
		'User_id' => 'int'
	];

	protected $fillable = [
		'star',
		'message',
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
}
