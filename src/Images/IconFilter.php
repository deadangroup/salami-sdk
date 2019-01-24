<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Images;

use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class IconFilter implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(30, 30);
    }
}
