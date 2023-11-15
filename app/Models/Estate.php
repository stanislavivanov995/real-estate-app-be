<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
>>>>>>> main

class Estate extends Model
{
    use HasFactory, SoftDeletes;

<<<<<<< HEAD
    protected $dates = ['deleted_at'];

    protected $table = 'estates';

=======
>>>>>>> main
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'description',
<<<<<<< HEAD
        'rooms',
=======
>>>>>>> main
        'price',
        'currency',
        'latitude',
        'longtitude',
        'category_id',
<<<<<<< HEAD
=======
        'rooms',
>>>>>>> main
        'arrive_hour',
        'leave_hour'
    ];

<<<<<<< HEAD
    public function getRelatedImages(int $id): ?array
    {
        return Image::whereEstateId($id)->get()->toArray();
    }

    public function images()
    {
        return $this->hasMany(Image::class);
=======
    public function estates()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
>>>>>>> main
    }
}
