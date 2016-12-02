<?php
namespace Deployer;
require 'recipe/laravel.php';

// Configuration

set('repository', 'git@bitbucket.org:bikebitants/bikebitants.git');

add('shared_files', []);
add('shared_dirs', ['public/img']);

add('writable_dirs', []);

// Servers

server('production', 'web.ovh.bikebitants.com')
    ->user('enricu')
    ->identityFile()
    ->set('deploy_path', '/var/www/new.bikebitants.com');


// Tasks
task('knock:penny', function () {
    runLocally('~/Development/./knock_titans.sh web.ovh.bikebitants.com');
});
before('deploy:prepare', 'knock:penny');
before('deploy:unlock', 'knock:penny');

/*desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    // The user must have rights for restart service
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
    run('sudo systemctl restart php-fpm.service');
});
after('deploy:symlink', 'php-fpm:restart');*/
