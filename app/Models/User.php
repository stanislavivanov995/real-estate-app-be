<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

<<<<<<< HEAD
    protected $table = 'users';

=======
>>>>>>> main
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];
<<<<<<< HEAD
    
    protected $hidden = [
        'password',
    ];
}
=======

    protected $hidden = [
        'password',
    ];
}
>>>>>>> main
