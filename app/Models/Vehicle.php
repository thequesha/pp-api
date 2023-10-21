<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['name'];

    public function mark()
    {
        return $this->belongsTo(Mark::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, 'vehicle_options');
    }
}