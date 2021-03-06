<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    protected $casts = [
        'processed' => 'bool'
    ];

    public function getProcessedStatusAttribute()
    {
        return ($this->processed) ? '已讀' : '未閱讀';
    }
}
