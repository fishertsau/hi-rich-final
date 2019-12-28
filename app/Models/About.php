<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published' => 'boolean'
    ];

    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking','asc');
    }
}
