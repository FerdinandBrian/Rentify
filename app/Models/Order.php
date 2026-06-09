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
 * @property string|null $return_condition_note
 * @property Carbon|null $returned_at
 *
 * @property Car $car
 * @property Feedback|null $feedback
 * @property User $user
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $casts = [
        'start_rent' => 'datetime',
        'end_rent' => 'datetime',
        'returned_at' => 'datetime',
        'User_id' => 'int',
    ];

    protected $fillable = [
        'id',
        'name',
        'call_number',
        'email',
        'status',
        'start_rent',
        'end_rent',
        'Car_series_number',
        'User_id',
        'return_condition_note',
        'returned_at',
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

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'Order_id');
    }
}
