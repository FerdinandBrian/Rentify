<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Penaltyorder
 *
 * @property int $payment_id
 * @property int $penalty_id
 *
 * @property Payment $payment
 * @property Penalty $penalty
 *
 * @package App\Models
 */
class Penaltyorder extends Model
{
    protected $table = 'penalty_payment';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'payment_id' => 'int',
        'penalty_id' => 'int',
    ];

    protected $fillable = [
        'payment_id',
        'penalty_id',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function penalty()
    {
        return $this->belongsTo(Penalty::class, 'penalty_id');
    }
}
