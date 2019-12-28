<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published' => 'boolean',
        'published_in_home' => 'boolean'
    ];

    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking','asc');
    }
}
