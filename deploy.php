<?php
namespace Deployer;

require 'vendor/autoload.php';
require 'recipe/common.php';
require 'recipe/laravel.php';
require 'contrib/npm.php';

// Ip hosts
set('ip_prod', '194.233.72.10'); // TODO: ip ec2 prod
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
    ->set('hostname', '{{ip_dev}}')
    ->set('stage', 'development')
    ->set('remote_user', 'deploy')
    ->set('identityFile', '~/.ssh/id_techld')
    ->set('branch', 'develop')
    ->set('deploy_path', '{{dev_action_path}}');

// Reset php
task('reload:php-fpm', function () {
    run('sudo /usr/sbin/service php8.1-fpm reload');
});

// Run npm development
// exec: dep npm:run:dev dev
task('npm:run:dev', function () {
    run('cd {{dev_action_path}}/current && npm install && npm run prod && php artisan storage:link');
});

// Run npm staging
// exec: dep npm:run:stg stg
task('npm:run:stg', function () {
    run('cd {{stg_action_path}}/current && npm install && npm run prod && php artisan storage:link');
});

// Run npm production
// exec: dep npm:run:prod prod
task('npm:run:prod', function () {
    run('cd {{prod_action_path}}/current && npm install && npm run prod && php artisan storage:link');
});

task('deploy', [
    'deploy:unlock',
    'deploy:prepare',
    'deploy:vendors',
    'deploy:symlink',
    'reload:php-fpm',
    'deploy:cleanup'
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');
