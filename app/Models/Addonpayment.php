<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Addonpayment
 * 
 * @property float|null $total_price
 * @property int $AddOn_id
 * @property string $Payment_id
 * @property string $Payment_Order_id
 * 
 * @property Addon $addon
 * @property Payment $payment
 *
 * @package App\Models
 */
class Addonpayment extends Model
{
	protected $table = 'addonpayment';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'total_price' => 'float',
		'AddOn_id' => 'int'
	];

	protected $fillable = [
		'total_price',
		'AddOn_id',
		'Payment_id',
		'Payment_Order_id'
	];

	public function addon()
	{
		return $this->belongsTo(Addon::class, 'AddOn_id');
	}

	public function payment()
	{
		return $this->belongsTo(Payment::class, 'Payment_id')
					->where('payment.id', '=', 'addonpayment.Payment_id')
					->where('payment.Order_id', '=', 'addonpayment.Payment_Order_id');
	}
}
