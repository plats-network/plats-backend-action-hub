<?php

namespace App\Services\Twitter;

use App\Services\Concerns\BaseTwitter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Log;

class TwitterApiService extends BaseTwitter {
    // define('FOLLOW', 1);
    // define('LIKE', 2);
    // define('SHARE', 3);
    // define('RETWEET', 4);
    // define('TWEET', 5);
    // define('POST', 6);
    // define('JOIN_GROUP', 7);
    // define('HASHTAG', 8);

    /**
     * Get user Follow
     *
     * @param $userId
     *
     * @return boolean|void
     */
    public function isHasTag($userTweetId = null, $keyHasTag = null)
    {
        $ver = config('app.twitter_api_ver');

        if (is_null($userTweetId) || $userTweetId == 'error') {
            return false;
        }
        $uri = "/{$ver}/users/{$userTweetId}/tweets?max_results=" . TWITTER_LIMIT;

        return $this->fetchData($uri, HASHTAG, $keyHasTag);
    }

    /**
     * Get user Following
     *
     * @param $userTweetId
     *
     * @return boolean|void
     */
    public function isFollowing($userTweetId = null, $keyFollow = null)
    {
        $ver = config('app.twitter_api_ver');

        if (is_null($userTweetId) || $userTweetId == 'error') {
            return false;
        }
        $uri = "/{$ver}/users/{$userTweetId}/following?max_results=" . TWITTER_LIMIT;

        return $this->fetchData($uri, FOLLOW, $keyFollow);
    }

    /**
     * Get user likes page
     *
     * @param $tweetId
     *
     * @return array|void
     */
    public function isLikes($userTweetId = null, $keyLike = null)
    {
        $ver = config('app.twitter_api_ver');

        if (is_null($userTweetId) || $userTweetId == 'error') {
            return false;
        }
        $uri = "/{$ver}/users/{$userTweetId}/liked_tweets?max_results=" . TWITTER_LIMIT;

        return $this->fetchData($uri, LIKE, $keyLike);
    }

    /**
     * Get user Retweets page
     *
     * @param $tweetId
     *
     * @return array|void
     */
    public function isUserRetweet($userTweetId = null)
    {
        $ver = config('app.twitter_api_ver');

        if (is_null($userTweetId)) {
            return fasle;
        }

        $uri = "/{$ver}/tweets/{$userTweetId}/retweeted_by?max_results=" . TWITTER_LIMIT;
        
        return $this->fetchData($uri, RETWEET, $userTweetId);
    }

    /**
     * Call api twitter
     *
     * @param $uri $request
     *
     * @return array|void
     */
    private function fetchData($uri, $type = LIKE, $key = null, $limit = 10)
    {
        $datas = [];
        if (is_null($uri)) { return false; }
        $res = $this->callApi($uri);

        if (is_null($res)) { return false; }
        $statusCode = $res->getStatusCode();
        $data = json_decode($res->getBody()->getContents());
        $i = ZERO;

        Log::info('Call api tweets', [
            'code' => $statusCode,
            'contents' => $data
        ]);

        do {
            if ($statusCode == 200) {
                if ($i <= 0) {
                    switch($type) {
                        case FOLLOW:
                            foreach($data->data as $item) {
                                $datas[] = $item->username;
                            }
                            break;
                        case HASHTAG:
                            foreach($data->data as $item) {
                                // $key: string | array
                                $contains = Str::contains($item->text, $key);

                                if ($contains) {
                                    return true;
                                }
                            }
                            break;
                        default:
                            foreach($data->data as $item) {
                                $datas[] = $item->id;
                            }
                    }

                    if (in_array($key, $datas)) {
                        return true;
                    }
                } else {
                    if (!isset($data->meta->next_token)) {
                        break;
                    }

                    $nextUri = $uri . "&pagination_token={$data->meta->next_token}";
                    $nextRes = $this->callApi($nextUri);
                    $nextData = json_decode($nextRes->getBody()->getContents());

                    if ($nextData->meta->result_count == 0) {
                        break;
                    }

                    switch($type) {
                        case FOLLOW:
                            foreach($data->data as $item) {
                                $datas[] = $item->username;
                            }
                            break;
                        case HASHTAG:
                            foreach($data->data as $item) {
                                // $key: string | array
                                $contains = Str::contains($item->text, $key);

                                if ($contains) {
                                    return true;
                                }
                            }
                            break;
                        default:
                            foreach($data->data as $item) {
                                $datas[] = $item->id;
                            }
                    }

                    if (in_array($key, $datas)) {
                        return true;
                    }
                }
            }

            $i++;
        } while($i < $limit);

        return false;
    }
}
