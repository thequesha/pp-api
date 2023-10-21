<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [
        'id',
    ];


    public function parent() // whereNull('parent_id');
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function parents()
    {
        return $this->parent()->with('parents');
    }


    public function child() // whereNotNull('parent_id')
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order');
    }


    public function children()
    {
        return $this->child()->with('children');
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'category_parts');
    }

}