<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estate extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'estates';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'rooms',
        'price',
        'currency',
        'latitude',
        'longtitude',
        'category_id',
        'arrive_hour',
        'leave_hour'
    ];

    public function getRelatedImages(int $id): ?array
    {
        return Image::whereEstateId($id)->get()->toArray();
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
