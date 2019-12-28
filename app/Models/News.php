<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class News extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published' => 'boolean'
    ];

    protected $dates = [
        'published_since',
        'published_until'
    ];

    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking', 'asc');
    }

    public function scopeWithinEffective($query)
    {
        $now = Carbon::parse('now');

        return
            $query
                ->where(function ($query) use ($now) {
                    $query->where('published_since', '<=', $now)
                        ->where('published_until', '>=', $now);
                })
                ->orWhere(function ($query) use ($now) {
                    $query->where('published_since', '<=', $now)
                        ->where('published_until', null);
                });
    }


    public function scopePublished($query)
    {
        return $query->where('published', true);
    }


    public function next()
    {
        $effectivePublishedNewsList = $this->getEffectivePublishedNewsList();

        $currentItemIndex = $this->getItemIndex($effectivePublishedNewsList, $this->id);

        $targetPosition =
            $this->isLastItem($currentItemIndex, $effectivePublishedNewsList) ?
                0 : $currentItemIndex + 1;

        return $effectivePublishedNewsList->pull($targetPosition);
    }


    public function previous()
    {
        $effectivePublishedNewsList = $this->getEffectivePublishedNewsList();

        $currentItemIndex = $this->getItemIndex($effectivePublishedNewsList, $this->id);

        $targetPosition =
            $this->isFirstItem($currentItemIndex) ?
                $this->lastItemIndex($effectivePublishedNewsList) : $currentItemIndex - 1;

        return $effectivePublishedNewsList->pull($targetPosition);
    }

    private function getEffectivePublishedNewsList()
    {
        return News::withinEffective()->published()->orderByDesc('published_since')->get();;
    }

    /**
     * @param $list
     * @return mixed
     */
    private function getItemIndex($list, $id)
    {
        return $list->pluck('id')->search($id);
    }

    /**
     * @param $index
     * @param $list
     * @return bool
     */
    private function isLastItem($index, $list): bool
    {
        return $index === ($this->lastItemIndex($list));
    }

    /**
     * @param $index
     * @return bool
     */
    private function isFirstItem($index): bool
    {
        return $index === 0;
    }

    /**
     * @param Collection $list
     * @return int
     */
    private function lastItemIndex(Collection $list): int
    {
        return $list->count() - 1;
    }

}
