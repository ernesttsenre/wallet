<?php
namespace Deployer;

require 'recipe/symfony.php';

// Project name
set('application', 'wallet');
set('bin_dir', 'bin');
set('var_dir', 'var');

// Project repository
set('repository', 'git@github.com:ernesttsenre/wallet.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
set('shared_dirs', ['var/logs']);

// Writable dirs by web server 
set('writable_dirs', ['var/cache', 'var/logs']);

// Hosts
host('185.143.172.30')
    ->user('user')
    ->port(22)
    ->multiplexing(true)
    ->set('deploy_path', '/home/user');

// Tasks
//task('build', function () {
//    run('cd {{release_path}} && build');
//});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'database:migrate');

