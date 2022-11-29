<?php

namespace App\Services\Twitter;

use App\Services\Concerns\BaseTwitter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Helpers\ActionHelper;
use Log;

class TwitterApiService extends BaseTwitter {
    /**
     * Get user Follow
     * @param $userId
     * @return boolean|void
     */
    public function isHashTag($userTweetId, $keyHashTag)
    {
        Log::info('Call hashtag: ', [
            'user_tweeter_id' => $userTweetId,
            'key_hashtag' => $keyHashTag
        ]);

        $ver = config('app.twitter_api_ver');
        if (is_null($userTweetId) || $userTweetId == '') { return [false, 'Tweet Id not found!']; }
        if (is_null($keyHashTag) || $keyHashTag == '') { return [false, 'Key hashtag not found!']; }

        $uri = "/{$ver}/users/{$userTweetId}/tweets?max_results=" . TWITTER_LIMIT;

        return $this->fetchData($uri, HASHTAG, $userTweetId, $keyHashTag);
    }

    /**
     * Get user Following
     *
     * @param $userTweetId
     *
     * @return boolean|void
     */
    public function isFollowing($userTweetId, $keyFollow)
    {
        Log::info('Call following: ', [
            'user_tweeter_id' => $userTweetId,
            'key_follow' => $keyFollow
        ]);

        $ver = config('app.twitter_api_ver');
        if (is_null($userTweetId) || $userTweetId == '') { return [false, 'Tweet Id not found!']; }
        if (is_null($keyFollow) || $keyFollow == '') { return [false, 'Key following not found!']; }

        $uri = "/{$ver}/users/{$userTweetId}/following?max_results=" . TWITTER_LIMIT;

        return $this->fetchData($uri, FOLLOW, $userTweetId, $keyFollow);
    }

    /**
     * Get user likes page
     *
     * @param $tweetId
     *
     * @return array|void
     */
    public function isLikes($userTweetId, $keyLike)
    {
        Log::info('Call api like: ', [
            'user_tweeter_id' => $userTweetId,
            'key_like' => $keyLike
        ]);

        $ver = config('app.twitter_api_ver');
        if (is_null($userTweetId) || $userTweetId == '') { return [false, 'Tweet Id not found!']; }
        if (is_null($keyLike) || $keyLike == '') { return [false, 'Key like not found!']; }

        $uri = "/{$ver}/users/{$userTweetId}/liked_tweets?max_results=" . TWITTER_LIMIT;

        return $this->fetchData($uri, LIKE, $userTweetId, $keyLike);
    }

    /**
     * Get user Retweets page
     *
     * @param $tweetId
     *
     * @return array|void
     */
    public function isUserRetweet($userTweetId, $keyRetweet)
    {
        Log::info('Call retweet: ', [
            'user_tweeter_id' => $userTweetId,
            'key_retweet' => $keyRetweet
        ]);
     
        $ver = config('app.twitter_api_ver');
        if (is_null($userTweetId) || $userTweetId == '') { return [false, 'Tweet Id not found!']; }
        if (is_null($keyRetweet) || $keyRetweet == '') { return [false, 'Retweet not found!']; }

        $uri = "/{$ver}/tweets/{$keyRetweet}/retweeted_by?max_results=" . TWITTER_LIMIT;

        return $this->fetchData($uri, RETWEET, $userTweetId, $keyRetweet);
    }

    /**
     * Call api twitter
     *
     * @param $uri $request
     *
     * @return array|void
     */
    private function fetchData($uri, $type = LIKE, $userTweetId, $key, $limit = 10)
    {
        $datas = [];
        $resultSuccess = [true, ActionHelper::getTypeStr($type)[1] . ' Success!'];
        $resultErrors = [false, "Not " . ActionHelper::getTypeStr($type)[1] . ' Yet?'];
        $resMessage = '';

        if (is_null($uri)) { return [false, 'Url not found!']; }
        $res = $this->callApi($uri);

        if (is_null($res)) { return [false, 'Data not found!']; }
        $statusCode = $res->getStatusCode();
        $data = json_decode($res->getBody()->getContents());

        Log::info('Call api tweets', [
            'code' => $statusCode
        ]);

        if ($statusCode != 200) {
            return [false, optional($data->errors[0])->message];
        }

        $i = ZERO;
        do {
            if ($statusCode == 200) {
                if ($i <= 0) {
                    switch($type) {
                        case FOLLOW:
                            if (isset($data->data)) {
                                foreach($data->data as $item) { $datas[] = $item->username; }
                            }
                            if (in_array($key, $datas)) { $resMessage = $resultSuccess; }
                            break;
                        case HASHTAG:
                            if (isset($data->data)) {
                                foreach($data->data as $item) {
                                    $contains = Str::contains($item->text, $key);
                                    if ($contains) { $resMessage = $resultSuccess; }
                                }
                            }
                            break;
                        case LIKE:
                            if (isset($data->data)) {
                                foreach($data->data as $item) { $datas[] = $item->id; }
                            }
                            if (in_array($key, $datas)) { $resMessage = $resultSuccess; }
                            break;
                        case RETWEET:
                            if (isset($data->data)) {
                                foreach($data->data as $item) { $datas[] = $item->id; }
                            }

                            if (in_array($userTweetId, $datas)) { $resMessage = $resultSuccess; }
                            break;
                        default:
                            $resMessage = $resultErrors;
                            break;
                    }
                } else {
                    if (!isset($data->meta->next_token)) { break; }

                    if ($i == 1) {
                        $nextUri = $uri . "&pagination_token={$data->meta->next_token}";
                        $nextRes = $this->callApi($nextUri);
                        $nextData = json_decode($nextRes->getBody()->getContents());
                    } else {
                        if (!isset($nextData->meta->next_token)) { break; }

                        $nextUri = $uri . "&pagination_token={$nextData->meta->next_token}";
                        $nextRes = $this->callApi($nextUri);
                        $nextData = json_decode($nextRes->getBody()->getContents());
                    }

                    if ($nextData->meta->result_count == 0) {
                        break;
                    }

                    switch($type) {
                        case FOLLOW:
                            if (isset($nextData->data)) {
                                foreach($nextData->data as $item) { $datas[] = $item->username; }
                            }
                            if (in_array($key, $datas)) { $resMessage = $resultSuccess; }
                            break;
                        case HASHTAG:
                            if (isset($nextData->data)) {
                                foreach($nextData->data as $item) {
                                    $contains = Str::contains($item->text, $key);
                                    if ($contains) { $resMessage = $resultSuccess; }
                                }
                            }
                            break;
                        case LIKE:
                            if (isset($nextData->data)) {
                                foreach($nextData->data as $item) { $datas[] = $item->id; }
                            }
                            if (in_array($key, $datas)) { $resMessage = $resultSuccess; }
                            break;
                        case RETWEET:
                            if (isset($nextData->data)) {
                                foreach($nextData->data as $item) { $datas[] = $item->id; }
                            }

                            if (in_array($userTweetId, $datas)) { $resMessage = $resultSuccess; }
                            break;
                        default:
                            $resMessage = $resultErrors;
                            break;
                    }
                }
            }

            $i++;
        } while($i < $limit);

        return $resMessage;
    }
}
