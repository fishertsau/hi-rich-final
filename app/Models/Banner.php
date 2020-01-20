<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'published' => 'boolean'
    ];

    public static function count()
    {
        return count(self::all());
    }

    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking', 'asc');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
