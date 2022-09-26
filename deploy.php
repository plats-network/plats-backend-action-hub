<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('prod', 'prod_plats_task');
set('stg', 'plats_action');

// Project repository
set('repository', 'git@github.com:plats-network/plats-backend-action-hub.git');

// Set release_or_current_path
set('release_or_prod_path', '/home/deploy/apps//{{prod}}');
set('release_or_stg_path', '/home/deploy/apps/{{stg}}');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', [
    '.env',
]);
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
host('production')
    ->hostname('194.233.72.10')
    ->stage('production')
    ->user('deploy')
    ->identityFile('~/.ssh/id_techld')
    ->set('branch', 'main')
    ->set('deploy_path', '{{release_or_prod_path}}');

host('staging')
    ->hostname('194.233.72.10')
    ->stage('staging')
    ->user('deploy')
    ->identityFile('~/.ssh/id_techld')
    ->set('branch', 'staging')
    ->set('deploy_path', '{{release_or_stg_path}}');

// Tasks
task('reload:php-fpm', function () { 
    run('sudo /usr/sbin/service php8.1-fpm reload'); 
});

task('npm:run:prod', function () {
    run('cd {{release_or_stg_path}}/current && npm install && npm run prod');
});

task('build', function () {
    run('cd {{release_path}} && build');
});

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'artisan:storage:link',
    'reload:php-fpm',
    'npm:run:prod',
    'success',
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');

