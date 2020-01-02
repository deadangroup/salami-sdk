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

class DynamicFilter implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        $w = request()->get('w', 50);
        $h = request()->get('h', 50);
        // $format = Input::get('fm', 'png');
        // $quality    = Input::get('q', 75);
        // $blur       = Input::get('blr', 0);
        // $brightness = Input::get('brght', 0);
        // $rgb        = Input::get('rgb', null);
        // $contrast   = Input::get('cntrst', 0);
        // $flip       = Input::get('flip', 'h');
        // $greyscale  = Input::get('grey', 'n');

        return $image->fit($w, $h);
    }
}
