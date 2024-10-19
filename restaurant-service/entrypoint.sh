#!/bin/sh

composer install --ignore-platform-reqs --no-scripts

sleep 5

php artisan migrate --force
php -S 0.0.0.0:8082 -t bootstrap bootstrap/app.php