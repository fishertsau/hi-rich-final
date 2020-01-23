<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\admin\PhotoHandler;

class CoverPhotoDeleting
{
    use PhotoHandler;

    public function __construct(Model $model)
    {
        $this->deleteCoverPhoto($model->photoPath);
    }
}
