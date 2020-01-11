<?php

namespace App\Models;

use App\Events\ProductDeleting;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category\ProductCategory;
use Illuminate\Database\Eloquent\Collection;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published' => 'boolean',
        'published_in_home' => 'boolean'
    ];

    protected $dispatchesEvents = [
        'deleting' => ProductDeleting::class,
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'cat_id');
    }


    public function scopeStatus($query, $status_flag)
    {
        if (is_bool($status_flag)) {
            return $query->where('published', $status_flag);
        }

        return null;
    }

    public function scopeKeyword($query, $keyword = null)
    {
        if (!empty($keyword)) {
            //add wildcard before and after keyword
            $keyword = '%' . $keyword . '%';

            return $query->where('title', 'like', $keyword)
                ->orWhere('title_en', 'like', $keyword);
        }
    }

    public function scopeCategories($query, $categories = null)
    {
        if (!$categories) {
            return;
        }

        if (is_array($categories)) {
            return $query->whereIn('cat_id', $categories);
        }

        return $query->where('cat_id', $categories);
    }

    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking');
    }

    public function scopePublished($query){
        return $query->wherePublished(true);
    }


    public function getCatSeriesTitlesAttribute()
    {
        return $this->category->seriesTitles;
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function productsByCat($catId)
    {
        return $this->published()->categories($catId)->get();
    }


    public function getIndexAttribute()
    {
        $index = 0;
        $targetEntity = $this;
        $rankedProduct = $this->productsByCat($this->cat_id)->sortBy('ranking');
        $rankedProduct->first(function ($value, $key) use ($targetEntity, &$index) {
            $index++;
            return $value->id === $targetEntity->id;
        });

        return $index;
    }


    public function getNextPublishedAttribute()
    {
        $rankedProducts = $this->productsByCat($this->cat_id)->sortBy('ranking');

        $entityIndex = $this->index;

        $targetIndex =
            ($entityIndex == $rankedProducts->count())
                ? $entityIndex
                : ++$entityIndex;

        return $this->getItemByIndex($rankedProducts, $targetIndex);
    }




    public function getPreviousPublishedAttribute()
    {
        $rankedProducts = $this->productsByCat($this->cat_id)->sortBy('ranking');

        $entityIndex = $this->index;

        $targetIndex = ($entityIndex == 1)
            ? 1
            : --$entityIndex;

        return $this->getItemByIndex($rankedProducts, $targetIndex);
    }

    /**
     * @param $rankedProduct
     * @param $index
     * @return mixed
     */
    private function getItemByIndex(Collection $rankedProduct, $index)
    {
        $pointer = 0;
        return $rankedProduct->first(function ($value, $key) use ($index, &$pointer) {
            $pointer++;
            return $pointer === $index;
        });
    }
}