<?php

namespace App\Models;

use App\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder;


class Estate extends Model
{
    use HasFactory, SoftDeletes, Prunable, Filterable;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'location',
        'description',
        'price',
        'currency',
        'latitude',
        'longitude',
        'category_id',
        'rooms',
        'arrive_hour',
        'leave_hour',
        'thumb',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'reservations')->withPivot('check_in', 'check_out');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'estate_id', 'id');
    }

    public function prunable(): Builder
    {
        return static::where('deleted_at', '!=', null);
    }
}
