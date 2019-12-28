<?php

namespace App\Events;

use App\Models\Sample;

class SampleDeleting
{
    private $sample;

    public function __construct(Sample $sample)
    {
        $this->sample = $sample;
        $this
            ->deleteCoverPhoto();
    }


    private function deleteCoverPhoto()
    {
        $this->deleteFile($this->sample->photoPath);
        return $this;
    }

    private function deleteFile($path)
    {
        \File::delete(public_path('storage') . '/' . $path);
    }
}
