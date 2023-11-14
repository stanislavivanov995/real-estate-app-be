<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

class Estate extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'currency',
        'latitude',
        'longtitude',
        'category_id',
        'rooms',
        'arrive_hour',
        'leave_hour'
    ];

    public function estates()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
