<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Penaltyorder
 * 
 * @property string $Payment_id
 * @property string $Payment_Order_id
 * @property int $Penalty_id
 * 
 * @property Payment $payment
 * @property Penalty $penalty
 *
 * @package App\Models
 */
class Penaltyorder extends Model
{
	protected $table = 'penaltyorder';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'Penalty_id' => 'int'
	];

	protected $fillable = [
		'Payment_id',
		'Payment_Order_id',
		'Penalty_id'
	];

	public function payment()
	{
		return $this->belongsTo(Payment::class, 'Payment_id')
					->where('payment.id', '=', 'penaltyorder.Payment_id')
					->where('payment.Order_id', '=', 'penaltyorder.Payment_Order_id');
	}

	public function penalty()
	{
		return $this->belongsTo(Penalty::class, 'Penalty_id');
	}
}
