<?php

namespace App\Models;

use App\Events\CategoryCreating;
use App\Events\CategoryDeleting;
use Illuminate\Database\Eloquent\Model;

Abstract class Category extends Model
{
    const FIRST_LEVEL = 1;
    const SECOND_LEVEL = 2;
    const THIRD_LEVEL = 3;
    
    const CatIndexList = [
        '產品類別' => 'p',
        '消息類別' => 'n'
    ];

    protected $guarded = [];

    protected $casts = [
        'activated' => 'boolean'
    ];

    protected $dispatchesEvents = [
        'deleting' => CategoryDeleting::class,
        'creating' => CategoryCreating::class,
    ];

    abstract public static function getCatIndex();

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
        return $query
            ->where('for', $this->getCatIndex()) 
            ->where('level', 1);
    }
    
    public function scopeForApplyModel($query)
    {
        return $query->where('for', $this->getCatIndex());
    }

    //TODO: Implement this : cover this with test
    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking', 'asc');
    }
}
