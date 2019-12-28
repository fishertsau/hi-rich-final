<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebConfig extends Model
{
    protected $table = 'web_config';
    protected $guarded = [];

    protected $casts = [
        'category_photo_enabled' => 'boolean'
    ];


    public static function firstOrCreate()
    {
        $webConfig = self::first();

        if (!$webConfig) {
            return self::create();
        }

        return $webConfig;
    }
}
