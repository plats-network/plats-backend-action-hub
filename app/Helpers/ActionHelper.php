<?php

namespace App\Helpers;


use Carbon\Carbon;

class ActionHelper
{
    /**
     * Return date timestamp format.
     *
     * @param  Carbon|\App\Models\Instance\SpecialDate|string|null  $date
     * @return string|null
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
            case 'hastag';
                $tweetType = HASHTAG;
                break;
            default:
                $tweetType = null;
        }

        return $tweetType;
    }
}
