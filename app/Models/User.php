<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password',
    ];

    public function userInfo(): HasOne
    {
        return $this->hasOne(UserInfo::class);
    }
    public function userProperties()
    {
        return $this->hasMany(Estate::class);
    }

    public function estates()
    {
        return $this->belongsToMany(Estate::class, 'reservations');
    }
}
