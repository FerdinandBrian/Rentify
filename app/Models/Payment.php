<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 *
 * @property string $id
 * @property string $method
 * @property string $status
 * @property float|null $total_price
 * @property string $Order_id
 * @property Order $order
 * @property Collection|Addon[] $addons
 * @property Penaltyorder|null $penaltyorder
 */
class Payment extends Model
{
    protected $table = 'payment';

    public $incrementing = false;

    public $timestamps = false;

    protected $casts = [
        'total_price' => 'float',
    ];

    protected $fillable = [
        'method',
        'status',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'Order_id');
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'addonpayment', 'Payment_id', 'AddOn_id')
            ->withPivot('total_price', 'Payment_Order_id');
    }

    public function penaltyorder()
    {
        return $this->hasOne(Penaltyorder::class, 'payment_id');
    }

    public function penalties()
    {
        return $this->belongsToMany(Penalty::class, 'penalty_payment', 'payment_id', 'penalty_id');
    }
}
