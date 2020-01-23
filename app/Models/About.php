<?php

namespace App\Models;

use App\Events\CoverPhotoDeleting;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published' => 'boolean'
    ];

    protected $dispatchesEvents = [
        'deleting' => CoverPhotoDeleting::class,
    ];

    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking','asc');
    }
    
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
