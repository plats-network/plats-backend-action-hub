<?php

namespace App\Services\Twitter;

use App\Services\Concerns\BaseTwitter;
use Illuminate\Support\Facades\Http;

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
     * @return array|void
     */
    public function getFollows($userId = null, $name = null)
    {
        $follows = [];
        $userId = 571432663; // Mock

        if (is_null($userId) || $userId == 'error') {
            return $follows;
        }
        $uri = "/2/users/{$userId}/followers?max_results=" . TWITTER_LIMIT;

        return $this->fetchData($uri);
    }

    /**
     * Get user Following
     *
     * @param $userId
     *
     * @return array|void
     */
    public function isFollowing($userId = null, $name = null)
    {
        $follows = [];
        $userId = 571432663; // Mock
        $name = 'tamarincrypto'; // mock

        if (is_null($userId) || $userId == 'error') {
            return $follows;
        }
        $uri = "/2/users/{$userId}/following?max_results=" . TWITTER_LIMIT;

        return $this->fetchData($uri, FOLLOW, $name);
    }

    /**
     * Get user likes page
     *
     * @param $tweetId
     *
     * @return array|void
     */
    public function getLikes($tweetId = null, $name = null)
    {
        $likes = [];

        $userId = 571432663; // Mock

        if (is_null($userId) || $userId == 'error') {
            return $follows;
        }
        $uri = "/2/users/{$userId}/liked_tweets?max_results=" . TWITTER_LIMIT;

        return $this->fetchData($uri);
    }

    /**
     * Get user Retweets page
     *
     * @param $tweetId $request
     *
     * @return array|void
     */
    public function getUserTweets($tweetId = null)
    {
        $userIds = [];
        $tweetId = 1590210694095736833;

        if (is_null($tweetId)) {
            return $userIds;
        }

        $uri = "/2/tweets/{$tweetId}/retweeted_by?max_results=" . TWITTER_LIMIT;
        
        return $this->fetchData($uri, FOLLOW, '');
    }

    private function fetchData($uri, $type = LIKE, $key = null, $limit = 10)
    {
        $datas = [];
        if (is_null($uri)) { return false; }
        $res = $this->callApi($uri);

        if (is_null($res)) { return false; }
        $statusCode = $res->getStatusCode();
        $data = json_decode($res->getBody()->getContents());
        $i = ZERO;

        do {
            if ($statusCode == 200) {
                if ($i <= 0) {
                    switch($type) {
                        case FOLLOW:
                        case RETWEET:
                            foreach($data->data as $item) {
                                $datas[] = $item->username;
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
                        case RETWEET:
                            foreach($data->data as $item) {
                                $datas[] = $item->username;
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
