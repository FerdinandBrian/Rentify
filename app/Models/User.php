<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'email_verified_at',
        'call_number',
        'password',
        'remember_token',
        'document',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getRoleNameAttribute()
    {
        return $this->role->name ?? null;
    }
<<<<<<< HEAD

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }
=======
>>>>>>> dfceab44e5d0f988ebd2414eade44c2f3175288c
}
