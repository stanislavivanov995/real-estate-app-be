<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estate extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'category',
        'arrive_hour',
        'leave_hour'
    ];

    public function get_related_images($id)
    {
        return Image::all()->where('estate_id', '==', $id)->toArray();
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
