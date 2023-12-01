<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder;
>>>>>>> origin/feature/book-41


class Image extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'filename',
        'path',
        // 'is_thumbnail',
        'estate_id',
=======
    use HasFactory, SoftDeletes, Prunable;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'path',
        'estate_id'
>>>>>>> origin/feature/book-41
    ];

    public function estates()
    {
<<<<<<< HEAD
        return $this->belongsTo(Estate::class);
=======
        return $this->belongsTo(Estate::class, 'estate_id', 'id');
    }

    public function prunable(): Builder
    {
        return static::where('deleted_at', '!=', null);
>>>>>>> origin/feature/book-41
    }
}
