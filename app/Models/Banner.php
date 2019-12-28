<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = [];

    public static function firstOrCreate($input)
    {
        $banner = Banner::first();

        if (!$banner) {
            return Banner::create($input);
        }

        $banner->update($input);

        return $banner;
    }

    public static function secondOrCreate($input)
    {
        if (Banner::all()->count() < 2) {
            return Banner::create($input);
        }

        $banner = Banner::last();
        $banner->update($input);

        return $banner;
    }

    public static function last()
    {
        return Banner::all()->last();
    }
}
