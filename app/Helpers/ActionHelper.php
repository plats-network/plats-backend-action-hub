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
            case 'like':
                $tweetType = LIKE;
                break;
            case 'follow':
                $tweetType = FOLLOW;
                break;
            case 'retweet':
                $tweetType = RETWEET;
                break;
            case 'tweet':
                $tweetType = TWEET;
                break;
            case 'hastag';
                $tweetType = HASHTAG;
                break;
            default:
                $tweetType = null;
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
        switch($tpye) {
            case LIKE:
                $tweetType = 'like';
                break;
            case FOLLOW:
                $tweetType = 'follow';
                break;
            case RETWEET:
                $tweetType = 'retweet';
                break;
            case TWEET:
                $tweetType = 'tweet';
                break;
            case HASHTAG:
                $tweetType = 'hastag';
                break;
            default:
                $tweetType = null;
        }

        return $tweetType;
    }

    /**
     *
     * @param  string|null  $tpye
     * @return int|null
     */
    public static function iconSocial($platform)
    {
        switch($platform) {
            case TWITTER:
                $icon = Storage::disk('s3')->url('icon/tweeter.png');
                break;
            case FACEBOOK:
                $icon = Storage::disk('s3')->url('icon/facebook.png');
                break;
            case DISCORD:
                $icon = Storage::disk('s3')->url('icon/discord.png');
                break;
            default:
                $icon = Storage::disk('s3')->url('icon/telegram.png');
        }

        return $icon;
    }
}
