<?php

namespace App\Models;

use App\Events\CategoryDeleting;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const FIRST_LEVEL = 1;
    const SECOND_LEVEL = 2;
    const THIRD_LEVEL = 3;

    protected $guarded = [];

    protected $casts = [
        'activated' => 'boolean'
    ];

    protected $dispatchesEvents = [
        'deleting' => CategoryDeleting::class,
    ];

    public function parentCategory()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    public function childCategories()
    {
        return $this->hasMany($this, 'parent_id');
    }


    public function getDescendantsAttribute()
    {
        return $this->descendants();
    }


    public function getHasDescendantsAttribute()
    {
        return $this->childCategories->count() > 0;
    }


    public function descendants()
    {
        $descendants = $this->childCategories;

        $descendants->each(function ($category) use ($descendants) {
            if ($category->hasDescendants) {
                $descendants->push($category->descendants());
            }
        });

        return $descendants->flatten();
    }


    public function getSeriesTitlesAttribute()
    {
        $title = $this->title;

        if ($this->parentCategory) {
            $title = $this->parentCategory->seriesTitles . '/' . $title;
        }

        return $title;
    }

    public function scopeMain($query)
    {
        return $query->where('level', 1);
    }


    //TODO: Implement this : cover this with test
    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking','asc');
    }
}
