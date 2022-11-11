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

    /**
     * Task
     */
    define('INACTIVE_TASK', 0);
    define('ACTIVE_TASK', 1);
    define('TYPE_FREE_TASK', 1);

    //User-Task-Status
    define('USER_WAITING_TASK', 0);
    define('USER_PROCESSING_TASK', 1);
    define('USER_COMPLETED_TASK', 2);
    define('USER_CANCEL_TASK', 3);
    define('USER_TIMEOUT_TASK', 4);
    define('USER_REJECT_TASK', 5);

    /**
     * Task Location
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
     * Task order
     */
    define('OUT_OF_ORDER', 0);
    define('IN_ORDER', 1);

    /**
     * Task type
     */
    define('CHECKIN', 1);
    define('INSTALL_APP', 2);
    define('VIDEO_WATCH', 3);
    define('SUBSCRIBE_AND_INTERACT', 4);

    /**
     * Task checkin type
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
}
