<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Penalty
 *
 * @property int $id
 * @property string $type
 * @property float|null $total_penalty
 *
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class Penalty extends Model
{
    protected $table = 'penalty';
    public $timestamps = false;

    protected $casts = [
        'total_penalty' => 'float',
    ];

    protected $fillable = [
        'type',
        'total_penalty',
    ];

    public function penaltyorder()
    {
        return $this->hasOne(Penaltyorder::class, 'penalty_id');
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'penalty_payment', 'penalty_id', 'payment_id');
    }
}
