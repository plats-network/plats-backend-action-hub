<?php

if (!defined('DEFINE_CONSTANT')) {
    define('DEFINE_CONSTANT', 'DEFINE_CONSTANT');

    define('PAGE_SIZE', 20);
    define('INPUT_MAX_LENGTH', 255);

    /**
     * User
     */
    define('USER_ROLE', 1);
    define('ADMIN_ROLE', 2);

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
}
