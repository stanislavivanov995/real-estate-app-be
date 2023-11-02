<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'filename',
        'path',
        // 'is_thumbnail',
        'estate_id',
    ];

    public function estates()
    {
        return $this->belongsTo(Estate::class);
    }
}