<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $guarded = [];

    protected $casts = [
        'processed' => 'boolean'
    ];


    public function getRegardingAttribute()
    {
        if (!$this->product) {
            return '聯絡我們';
        }

        return '詢問表單';
    }

    public function getProcessedStatusAttribute()
    {
        return ($this->processed) ? '已完成' : '未完成';
    }
}
