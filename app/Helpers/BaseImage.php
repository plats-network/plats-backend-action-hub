<?php

namespace App\Helpers;

use Storage;

class BaseImage {
    public static function loadImage($image_url = null)
    {
        if (is_null($image_url)) {
            return Storage::disk('s3')->url('icon/hidden_box.png');
        }

        return Storage::disk('s3')->url($image_url);
    }
}
