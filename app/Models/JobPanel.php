<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Panel members (Users) linked to jobs
 */
class JobPanel extends Model
{
    use HasFactory;

    protected $table = 'job_panels';

    // Moved to applications.
//    public function reviews(): HasMany
//    {
//        return $this->hasMany(Review::class, 'panel_id', 'id');
//    }
}
