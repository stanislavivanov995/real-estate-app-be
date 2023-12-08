<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInfo extends Model
{
    protected $fillable = [
        "avatar",
        "bio",
        "phone",
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
