<?php

if (!defined('DEFINE_ADMIN_ROUTER')) {
    define('DEFINE_ADMIN_ROUTER', 'DEFINE_ADMIN_ROUTER');

    //Auth
    define('LOGIN_ADMIN_ROUTE', 'admin.login.route');
    define('LOGOUT_ADMIN_ROUTE', 'admin.logout.route');

    define('DASHBOARD_ADMIN_ROUTER', 'admin.dashboard.route');
    define('TASK_LIST_ADMIN_ROUTER', 'admin.task.list.route');
    define('TASK_CREATE_ADMIN_ROUTER', 'admin.task.create.route');
    define('TASK_EDIT_ADMIN_ROUTER', 'admin.task.edit.route');
    define('TASK_STORE_ADMIN_ROUTER', 'admin.task.store.route');
}
