<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Images\Filters;

use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class PartialBlurFilter implements FilterInterface
{
    private $width;
    private $height;
    private $x;
    private $y;
    
    public function __construct($width = 300, $height = 300, $x = 0, $y = 0)
    {
        $this->width = $width;
        $this->height = $height;
        $this->x = $x;
        $this->y = $y;
    }
    
    public function applyFilter(Image $image)
    {
        $crop = clone $image;
        $crop->crop($this->width, $this->height, $this->x, $this->y)->blur(100);
        $image->insert($crop, 'top-left', $this->x, $this->y);
        return $image;
    }
}
