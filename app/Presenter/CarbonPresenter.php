<?php

namespace App\Presenter;


use Carbon\Carbon;

class CarbonPresenter
{
    public function today()
    {
        return Carbon::now()->toDateString();
    }

    public function monthsFromNow($months = 0)
    {
        return Carbon::now()->addMonth($months)->toDateString();
    }
}