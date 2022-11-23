<?php

namespace App\Helpers;

use Storage;

class ActionHelper
{
    /**
     *
     * @param  string|null  $tpye
     * @return int|null
     */
    public static function getTypeTwitter($tpye): ?string
    {
        switch($tpye) {
            case 'follow':
                $tweetType = FOLLOW;
                break;
            case 'retweet':
                $tweetType = RETWEET;
                break;
            case 'tweet':
                $tweetType = TWEET;
                break;
            case 'hashtag';
                $tweetType = HASHTAG;
                break;
            default:
                $tweetType = LIKE;
        }

        return $tweetType;
    }

    /**
     *
     * @param  integer|null $tpye
     * @return string|null
     */
    public static function getTypeStr($tpye)
    {
        $datas = [];
        switch($tpye) {
            case FOLLOW:
                $datas = ['follow', 'Follow'];
                break;
            case RETWEET:
                $datas = ['retweet', 'Retweet'];
                break;
            case TWEET:
                $datas = ['tweet', 'Tweet'];
                break;
            case HASHTAG:
                $datas = ['hashtag', 'Hashtag'];
                break;
            default:
                $datas = ['like', 'Like'];
        }

        return $datas;
    }

    /**
     *
     * @param  integer|null $tpye
     * @return string|null
     */
    public static function getUrlIntent($tpye, $url)
    {
        $urlTwitter = 'https://twitter.com/intent';
        $urlIntent = $url ? last(explode('/', $url)) : null;
        $datas = [];
        switch($tpye) {
            case FOLLOW:
                $data = $urlTwitter . '/follow?screen_name=' . $urlIntent;
                break;
            case RETWEET:
                $data = $urlTwitter . '/retweet?tweet_id=' . $urlIntent;
                break;
            case TWEET:
                $data = $urlTwitter . '/tweet?hashtags=Plasts';
                break;
            case HASHTAG:
                $data = $urlTwitter . '/tweet?hashtags=Plasts';
                break;
            default:
                $data = $urlTwitter . '/like?tweet_id=' . $urlIntent;
        }

        return $data;
    }


    /**
     *
     * @param  string|null  $tpye
     * @return int|null
     */
    public static function iconSocial($platform)
    {
        $s3 = Storage::disk('s3');
        switch($platform) {
            case TWITTER:
                $icon = $s3->url('icon/tweeter.png');
                break;
            case FACEBOOK:
                $icon = $s3->url('icon/facebook.png');
                break;
            case DISCORD:
                $icon = $s3->url('icon/discord.png');
                break;
            default:
                $icon = $s3->url('icon/telegram.png');
        }

        return $icon;
    }
}
