<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOrganize extends Model
{
    public function organize(): BelongsTo
    {
        return $this->belongsTo(Organize::class);
    }
}
