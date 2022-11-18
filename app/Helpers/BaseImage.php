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

    public static function getType($type)
    {
        switch($type) {
            case 0:
                $type_label = 'token';
                break;
            case 1:
                $type_label = 'nft';
                break;
            case 2:
                $type_label = 'voucher';
                break;
            default:
                $type_label = 'card';
        }

        return $type_label;
    }
}