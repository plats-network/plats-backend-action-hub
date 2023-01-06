<?php

if (!defined('DEFINE_CONSTANT')) {
    define('DEFINE_CONSTANT', 'DEFINE_CONSTANT');

    // Zero
    define('ZERO', 0);

    define('PAGE_SIZE', 20);
    define('INPUT_MAX_LENGTH', 255);

    /**
     * User
     */
    define('USER_ROLE', 1);
    define('ADMIN_ROLE', 2);
    define('CLIENT_ROLE', 3);

    // Task LIKE, PIN
    define('TASK_LIKE', 0);
    define('TASK_PIN', 1);

    /**
     * Tasks
     */
    define('INACTIVE_TASK', 0);
    define('ACTIVE_TASK', 1);
    define('TYPE_FREE_TASK', 1);

    //User-Tasks-Status
    define('USER_WAITING_TASK', 0);
    define('USER_PROCESSING_TASK', 1);
    define('USER_COMPLETED_TASK', 2);
    define('USER_CANCEL_TASK', 3);
    define('USER_TIMEOUT_TASK', 4);
    define('USER_REJECT_TASK', 5);

    /**
     * Tasks Location
     */
    define('INACTIVE_LOCATION_TASK', 0);
    define('ACTIVE_LOCATION_TASK', 1);

    /**
     * Withdraw status
     */
    define('WITHDRAWN_STATUS_PENDING', 0);
    define('WITHDRAWN_STATUS_PROCESSING', 1);
    define('WITHDRAWN_STATUS_COMPLETED', 2);

    /**
     * Tasks order
     */
    define('OUT_OF_ORDER', 0);
    define('IN_ORDER', 1);

    /**
     * Tasks type
     */
    define('TYPE_CHECKIN', 1);
    define('TYPE_INSTALL_APP', 2);
    define('TYPE_VIDEO_WATCH', 3);
    define('TYPE_SOCIAL', 4);

    /**
     * Tasks checkin type
     */
    define('ONE_OF_MANY_LOCATIONS', 1);
    define('MULTIPLE_LOCATIONS', 2);

    /**
     * User Reward Type
     */
    define('REWARD_TOKEN', 0);
    define('REWARD_NFT', 1);
    define('REWARD_VOUCHER', 2);
    define('REWARD_BOX', 3);
    define('REWARD_WALLET', 4);

    // TWITTER
    define('TWITTER_LIMIT', 100);

    /**
     * Tasks type platform
     */
    define('TWITTER', 1);
    define('FACEBOOK', 2);
    define('DISCORD', 3);
    define('TELEGRAM', 4);

    // Twitter
    define('TWITTER_FOLLOW', 0);
    define('TWITTER_LIKE', 1);
    define('TWITTER_RETWEET', 2);
    define('TWITTER_TWEET', 3);

    // Facebook
    define('FACEBOOK_SHARE', 0);
    define('FACEBOOK_LIKE', 1);
    define('FACEBOOK_POST', 2);
    define('FACEBOOK_JOIN_GROUP', 3);

    // Telegram
    define('TELEGRAM_JOIN', 0);

    // Discord
    define('DISCORD_JOIN', 0);

    /**
     * Tasks type action
     */
    define('FOLLOW', 1);
    define('LIKE', 2);
    define('SHARE', 3);
    define('RETWEET', 4);
    define('TWEET', 5);
    define('POST', 6);
    define('JOIN_GROUP', 7);
    define('HASHTAG', 8);
}
