<?php

namespace App\ImageTemplates;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Slide implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(1400, 500);
    }
}
