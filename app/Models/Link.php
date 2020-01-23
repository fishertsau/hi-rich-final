<?php

namespace App\Models;

use App\Events\CoverPhotoDeleting;
use App\Models\Category\LinkCategory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'published' => 'boolean'
    ];

    protected $dispatchesEvents = [
        'deleting' => CoverPhotoDeleting::class,
    ];
    
    public function category()
    {
        return $this->belongsTo(LinkCategory::class, 'cat_id');
    }
    
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
