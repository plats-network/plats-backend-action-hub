<?php

namespace App\Services\Twitter;

use App\Services\Concerns\BaseTwitter;
use Illuminate\Support\Facades\Http;

class TwitterApiService extends BaseTwitter {
    /**
     * Get user Follow
     *
     * @param $userId
     *
     * @return array|void
     */
    public function getFollows($userId = null)
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
     * Get user likes page
     *
     * @param $tweetId
     *
     * @return array|void
     */
    public function getLikes($tweetId = null)
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
        
        return $this->fetchData($uri);
    }

    private function fetchData($uri = null, $limit = 5)
    {
        $datas = [];
        if (is_null($uri)) {
            return $datas;
        }

        $res = $this->callApi($uri);

        if (is_null($res)) {
            return $datas;
        }

        $statusCode = $res->getStatusCode();
        $i = ZERO;

        do {
            if ($statusCode == 200) {
                if ($i <= 0) {
                    $data = json_decode($res->getBody()->getContents());
                    foreach($data->data as $item) {
                        $datas[] = $item->username;
                    }
                } else {
                    $nextUri = $uri . "&pagination_token={$data->meta->next_token}";
                    $nextRes = $this->callApi($nextUri);
                    $nextData = json_decode($nextRes->getBody()->getContents());

                    if ($nextData->meta->result_count == 0) {
                        break;
                    }

                    foreach($nextData->data as $item) {
                        $datas[] = $item->username;
                    }
                }
            }

            $i++;
        } while($i < $limit);
        
        return $datas;
    }
}
