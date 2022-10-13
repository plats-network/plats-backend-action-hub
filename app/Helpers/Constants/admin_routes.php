<?php

if (!defined('DEFINE_ADMIN_ROUTER')) {
    define('DEFINE_ADMIN_ROUTER', 'DEFINE_ADMIN_ROUTER');

    //Auth
    define('LOGIN_ADMIN_ROUTE', 'admin.login.route');
    define('LOGOUT_ADMIN_ROUTE', 'admin.logout.route');

    // Dashboard
    define('DASHBOARD_ADMIN_ROUTER', 'admin.dashboard.route');

    // Task
    define('TASK_LIST_ADMIN_ROUTER', 'admin.task.list.route');
    define('TASK_CREATE_ADMIN_ROUTER', 'admin.task.create.route');
    define('TASK_EDIT_ADMIN_ROUTER', 'admin.task.edit.route');
    define('TASK_STORE_ADMIN_ROUTER', 'admin.task.store.route');
    define('TASK_DEPOSIT_ADMIN_ROUTER', 'admin.task.deposit.route');

    // Reward
    define('REWARD_LIST_ADMIN_ROUTER', 'admin.reward.list.route');
    define('REWARD_CREATE_ADMIN_ROUTER', 'admin.reward.create.route');
    define('REWARD_EDIT_ADMIN_ROUTER', 'admin.reward.edit.route');
    define('REWARD_STORE_ADMIN_ROUTER', 'admin.reward.store.route');

    // Guild
    define('GUILD_LIST_ADMIN_ROUTER', 'admin.guild.list.route');

    // Company
    define('COMPANY_LIST_ADMIN_ROUTER', 'admin.company.list.route');
    define('COMPANY_CREATE_ADMIN_ROUTER', 'admin.company.create.route');
    define('COMPANY_EDIT_ADMIN_ROUTER', 'admin.company.edit.route');
    define('COMPANY_STORE_ADMIN_ROUTER', 'admin.company.store.route');
}
