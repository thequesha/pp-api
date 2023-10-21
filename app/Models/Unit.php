<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name',
    ];

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'unit_parts');
    }
}