<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class UserTaxonomies extends MorphPivot {

    protected $fillable = ['category'];

}
