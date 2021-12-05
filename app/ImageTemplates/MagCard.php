<?php

namespace App\ImageTemplates;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class MagCard implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(250, 250);
    }
}