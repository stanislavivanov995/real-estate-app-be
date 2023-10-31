<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    protected $table = 'estates';

    // protected $hidden = ['user_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'title',
        'city',
        'address',
        'type',
        'rooms',
        'price',
    ];
}
