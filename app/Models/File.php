<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'user_id', 'subfolder_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subfolder(): BelongsTo
    {
        return $this->belongsTo(Subfolder::class);
    }
}
