<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'original_url', 'shortener_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //shortenUrl
    //Save url by code key
    public static function shortenUrl($url, $length = 1)
    {
        //Check url exist
        $urlCheck = Url::query()
            ->where('original_url', $url)
            ->first();
        if($urlCheck) {
            return route('shortener-url',  ['shortener_url' => $urlCheck->shortener_url ]);
        }

        $codeShort = Str::random($length);

        //Check code exist
        $codeCheck = Url::query()
            ->where('shortener_url', $codeShort)
            ->first();

        if($codeCheck) {
            return route('shortener-url',  ['shortener_url' => $codeCheck->shortener_url ]);
        }else{
            $codeShort = Str::random($length);
        }

        $data['user_id'] = Auth::user()->id;
        $data['title'] = 'Code: '. $codeShort; // 'Code: 12345
        $data['original_url'] = $url;

        $data['shortener_url'] = $codeShort;

        $model =  Url::create($data);

        return route('shortener-url',  ['shortener_url' => $data['shortener_url'] ]);
    }
}
