<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;


class Image extends Model
{
    use HasFactory, SoftDeletes, Prunable;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'path',
        'estate_id'
    ];

    public function estates()
    {
        return $this->belongsTo(Estate::class, 'estate_id', 'id');
    }

    public function prunable(): Builder
    {
        return static::where('deleted_at', '!=', null);
    }
    
    protected function pruning(): void
    {
        File::delete($this->path);
    }
}
