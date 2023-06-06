<?php


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\{Task, User};

// Task
if (!function_exists('genCodeTask')) {
    function genCodeTask() {
        $hash = randStrHash(20);
        if (existCodeTask($hash)) {
            return genCodeTask();
        }
        return $hash;
    }
}

if (!function_exists('existCodeTask')) {
    function existCodeTask($hash) {
        return Task::whereCode($hash)->exists();
    }
}
// EndTask


if (!function_exists('codeCardNumber')) {
    function codeCardNumber() {
        $number = mt_rand(100000000000, 999999999999);

        if (checkExists($number)) {
            return codeCardNumber();
        }

        return $number;
    }
}

if (!function_exists('qrNumberCode')) {
    // Gen mã code cho mỗi user (uniq)
    function qrNumberCode () {
        $hash = randStrHash(8);
        if (checkExists($hash, 'cardQr')) {
            return qrNumberCode();
        }

        return $hash;
    }
}

if (!function_exists('affiliateCode')) {
    // Gen mã giới thiệu
    function affiliateCode () {
        $hash = randStrHash(6);
        if (checkExists($hash, 'affiliate')) {
            return affiliateCode();
        }

        return $hash;
    }
}

if (!function_exists('checkExists')) {
    function checkExists($hash, $type = 'cardCode') {
        switch($type) {
            case 'cardQr':
                $checkExists = User::whereQrCode($hash)->exists();
                break;
            case 'affiliate';
                $checkExists = User::whereAffiliateCode($hash)->exists();
                break;
            default:
                $checkExists = CardData::whereHashCode($hash)->exists();
                break;
        }

        return $checkExists;
    }
}

if (!function_exists('randStrHash')) {
    function randStrHash($num) {
        $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJLMNOPRSTUVWXYZ';
        return substr(str_shuffle($string), 0, $num);
    }
}

if (!function_exists('commonImg')) {
    function commonImg($img) {
        if (is_null($img) || $img == '') {
            return null;
        }

        return Storage::disk('s3')->url($img);
    }
}