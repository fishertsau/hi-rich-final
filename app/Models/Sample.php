<?php

namespace App\Models;

use App\Events\SampleDeleting;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published' => 'boolean'
    ];

    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking','asc');
    }


    protected $dispatchesEvents = [
        'deleting' => SampleDeleting::class,
    ];
}
