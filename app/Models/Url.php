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
    public static function shortenUrl($url)
    {
        //Check url exist
        $urlCheck = Url::query()
            ->where('original_url', $url)
            ->first();
        if($urlCheck) {
            return route('shortener-url',  ['shortener_url' => $urlCheck->shortener_url ]);
        }
        $data['user_id'] = Auth::user()->id;
        $data['title'] = 'Code: '.Str::random(5); // 'Code: 12345
        $data['original_url'] = $url;
        $data['shortener_url'] = Str::random(5);

        $model =  Url::create($data);

        return route('shortener-url',  ['shortener_url' => $data['shortener_url'] ]);
    }
}
