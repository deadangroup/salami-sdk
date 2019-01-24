<?php

namespace Deadan\Support\Images;

use Image;
use Deadan\Support\Http\Controller;

class ImageController extends Controller
{
    /**
     * Generate a thumbnail for a given image
     *
     * @param $image_src
     * @param int $width
     * @param int $height
     * @param int $quality
     * @return mixed
     */
    public function generateThumbnail($image_src, $width = 320, $height = 240, $quality = 90)
    {
        $img = Image::make(asset($image_src));

        $img->resize($width, $height);

//        $img->insert('public/watermark.png');

//        $img->save('public/bar.jpg');

        return $img->response($quality);
    }
}
