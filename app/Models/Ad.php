<?php

namespace App\Models;

use App\Events\CoverPhotoDeleting;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    const LOCATION_BANNER = 1;
    const LOCATION_HOME_PAGE = 2;
    const LOCATION_HOME_ACTIVITY = 3; 
    
    const LOCATIONS = [
        self::LOCATION_BANNER => '跑馬燈',
        self::LOCATION_HOME_PAGE => '首頁產品',
        self::LOCATION_HOME_ACTIVITY => '首頁活動'
    ];

    protected $guarded = [];
    protected $appends = ['location_title'];

    protected $casts = [
        'published' => 'boolean'
    ];

    protected $dispatchesEvents = [
        'deleting' => CoverPhotoDeleting::class,
    ];

    public static function count()
    {
        return count(self::all());
    }

    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking', 'asc');
    }

    public function scopeOrderByLocation($query)
    {
        return $query->orderBy('location', 'asc');
    }
    
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function getLocationTitleAttribute()
    {
        return self::LOCATIONS[$this->location];
    }
}
