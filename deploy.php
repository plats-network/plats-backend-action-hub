<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('prod', 'prod_plats_task');
set('stg', 'plats_task');
set('dev', 'dev_plats_task');

// Project repository
set('repository', 'git@github.com:plats-network/plats-backend-action-hub.git');

// Set release_or_current_path
set('release_or_prod_path', '/home/deploy/apps//{{prod}}');
set('release_or_stg_path', '/home/deploy/apps/{{stg}}');
set('release_or_dev_path', '/home/deploy/apps/{{dev}}');

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
    ->hostname('139.59.109.139')
    ->stage('production')
    ->user('deploy')
    ->identityFile('~/.ssh/id_techld')
    ->set('branch', 'main')
    ->set('deploy_path', '{{release_or_prod_path}}');

host('staging')
    ->hostname('139.59.109.139')
    ->stage('staging')
    ->user('deploy')
    ->identityFile('~/.ssh/id_techld')
    ->set('branch', 'staging')
    ->set('deploy_path', '{{release_or_stg_path}}');

host('development')
    ->hostname('139.59.109.139')
    ->stage('development')
    ->user('deploy')
    ->identityFile('~/.ssh/id_techld')
    ->set('branch', 'develop')
    ->set('deploy_path', '{{release_or_dev_path}}');
    
// Tasks
// task('reload:php-fpm', function () { 
//     run('sudo /usr/sbin/service php7.4-fpm reload'); 
// });

task('build', function () {
    run('cd {{release_path}} && build');
});

task('deploy', [
    // outputs the branch and IP address to the command line
    'deploy:info',
    // preps the environment for deploy, creating release and shared directories
    'deploy:prepare',
    // adds a .lock file to the file structure to prevent numerous deploys executing at once
    'deploy:lock',
    // removes outdated release directories and creates a new release directory for deploy
    'deploy:release',
    // clones the project Git repository
    'deploy:update_code',
    // loops around t he list of shared directories defined in the config file
    // and generates symlinks for each
    'deploy:shared',
    // loops around the list of writable directories defined in the config file
    // and changes the owner and permissions of each file or directory
    'deploy:writable',
    // if Composer is used on the site, the Composer install command is executed
    'deploy:vendors',
    // loops around release and removes unwanted directories and files
    'deploy:clear_paths',
    // links the deployed release to the "current" symlink
    'deploy:symlink',
    // deletes the unlock file, allowing further deploys to be executed
    'deploy:unlock',
    // loops around a list of release directories and removes any which are now outdated
    'cleanup',
    // can be used by the user to assign custom tasks to execute on successful deployments
    'artisan:storage:link',
    // 'reload:php-fpm',
    'success',
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');

