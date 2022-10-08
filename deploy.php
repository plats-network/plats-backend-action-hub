<?php
<?php
namespace Deployer;

require 'vendor/autoload.php';
require 'recipe/common.php';
require 'recipe/laravel.php';
require 'contrib/npm.php';

// Ip hosts
set('ip_prod', 'xx.xx.xx.xx'); // TODO: ip ec2 prod
set('ip_stg', '194.233.72.10');
set('ip_dev', '194.233.72.10');

// Project name
set('prod', 'prod_action');
set('stg', 'plats_action');
set('dev', 'dev_action');

// Project repository
set('repository', 'git@github.com:plats-network/plats-backend-action-hub.git');

// Set release_or_current_path
set('prod_action_path', '/home/deploy/apps/{{prod}}');
set('stg_action_path', '/home/deploy/apps/{{stg}}');
set('dev_action_path', '/home/deploy/apps/{{dev}}');

// Set number of releases to keep
set('keep_releases', 5);

// Writable dirs by web server
set('allow_anonymous_stats', false);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
add('shared_files', ['.env']);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

// Hosts
host('prod')
    ->set('hostname', '{{ip_prod}}')
    ->set('stage', 'production')
    ->set('user', 'deploy')
    ->set('identityFile', '~/.ssh/id_techld')
    ->set('branch', 'main')
    ->set('deploy_path', '{{prod_action_path}}');

host('stg')
    ->set('hostname', '{{ip_stg}}')
    ->set('stage', 'staging')
    ->set('remote_user', 'deploy')
    ->set('identityFile', '~/.ssh/id_techld')
    ->set('branch', 'staging')
    ->set('deploy_path', '{{stg_action_path}}');

host('dev')
    ->set('hostname', '{{ip_stg}}')
    ->set('stage', 'staging')
    ->set('remote_user', 'deploy')
    ->set('identityFile', '~/.ssh/id_techld')
    ->set('branch', 'staging')
    ->set('deploy_path', '{{dev_action_path}}');

// Reset php
task('reload:php-fpm', function () {
    run('sudo /usr/sbin/service php8.1-fpm reload');
});

// Run npm development
// exec: dep npm:run:dev dev
task('npm:run:dev', function () {
    run('cd {{dev_notice_path}}/current && npm install && npm run prod');
});

// Run npm staging
// exec: dep npm:run:stg stg
task('npm:run:stg', function () {
    run('cd {{stg_notice_path}}/current && npm install && npm run prod');
});

// Run npm production
// exec: dep npm:run:prod prod
task('npm:run:prod', function () {
    run('cd {{prod_notice_path}}/current && npm install && npm run prod');
});

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:symlink',
    'reload:php-fpm',
    'deploy:publish',
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');

// OLD
// namespace Deployer;

// require 'recipe/laravel.php';

// // Project name
// set('prod', 'prod_plats_task');
// set('stg', 'plats_action');

// // Project repository
// set('repository', 'git@github.com:plats-network/plats-backend-action-hub.git');

// // Set release_or_current_path
// set('release_or_prod_path', '/home/deploy/apps//{{prod}}');
// set('release_or_stg_path', '/home/deploy/apps/{{stg}}');

// // [Optional] Allocate tty for git clone. Default value is false.
// set('git_tty', true); 

// // Shared files/dirs between deploys 
// add('shared_files', [
//     '.env',
// ]);
// add('shared_dirs', []);

// // Writable dirs by web server 
// add('writable_dirs', [
//     'bootstrap/cache',
//     'storage',
//     'storage/app',
//     'storage/app/public',
//     'storage/framework',
//     'storage/framework/cache',
//     'storage/framework/sessions',
//     'storage/framework/views',
//     'storage/logs',
// ]);

// // Hosts
// host('production')
//     ->hostname('194.233.72.10')
//     ->stage('production')
//     ->user('deploy')
//     ->identityFile('~/.ssh/id_techld')
//     ->set('branch', 'main')
//     ->set('deploy_path', '{{release_or_prod_path}}');

// host('staging')
//     ->hostname('194.233.72.10')
//     ->stage('staging')
//     ->user('deploy')
//     ->identityFile('~/.ssh/id_techld')
//     ->set('branch', 'staging')
//     ->set('deploy_path', '{{release_or_stg_path}}');

// // Tasks
// task('reload:php-fpm', function () { 
//     run('sudo /usr/sbin/service php8.1-fpm reload'); 
// });

// task('npm:run:prod', function () {
//     run('cd {{release_or_stg_path}}/current && npm install && npm run prod');
// });

// task('build', function () {
//     run('cd {{release_path}} && build');
// });

// task('deploy', [
//     'deploy:info',
//     'deploy:prepare',
//     'deploy:lock',
//     'deploy:release',
//     'deploy:update_code',
//     'deploy:shared',
//     'deploy:writable',
//     'deploy:vendors',
//     'deploy:clear_paths',
//     'deploy:symlink',
//     'deploy:unlock',
//     'cleanup',
//     'artisan:storage:link',
//     'reload:php-fpm',
//     'npm:run:prod',
//     'success',
// ]);

// // [Optional] if deploy fails automatically unlock.
// after('deploy:failed', 'deploy:unlock');

// // Migrate database before symlink new release.
// before('deploy:symlink', 'artisan:migrate');

