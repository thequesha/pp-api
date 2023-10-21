<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parameter extends Model
{

    protected $fillable = [
        'name',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}
