<?php

namespace App\Services\Twitter;

use Illuminate\Support\Facades\Http;

class TwitterApiService {
    /**
     * Auto paginate with query parameters
     *
     * @param  array  $username
     *
     * @return id
     */

    public function getTWitterId($username = null)
    {
        try {
            $res = Http::get(config('app.twitter_gen_url') . '/api/fetchTwitterId?username=' . $username);
            $data = json_decode($res->getBody()->getContents());

            $twitterId = $data->id;
        } catch (\Exception $e) {
            $twitterId = 'error';
        }

        return $twitterId;
    }


    public function getLikes()
    {
        // TODO:
    }

    public function reTweet()
    {
        
    }


    // Get Token
    private function getToken()
    {
        return config('app.twitter_token');
    }


    private callApi($method = 'GET', $uri = null)
    {
        switch($method) {
            case "GET":
            case "get":
                $res = Http::withToken($this->getToken())
                    ->get(config('app.twitter_api_url') . $uri);
                break;
            case "POST":
            case "post":
                $res = Http::withToken($this->getToken())
                    ->post(config('app.twitter_api_url') . $uri);
                break;
            default:
                $res null;
        }

        return $res;
    }
}
