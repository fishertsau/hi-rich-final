<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published' => 'boolean'
    ];
    
    public static function count()
    {
        return count(self::all());
    }
}
