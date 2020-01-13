<?php

namespace App\Models;

use App\Models\Category\LinkCategory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'published' => 'boolean'
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
