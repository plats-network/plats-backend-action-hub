<?php

namespace App\Services\Twitter;

use Illuminate\Support\Facades\Http;

class TwitterGenIdService {
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
}
