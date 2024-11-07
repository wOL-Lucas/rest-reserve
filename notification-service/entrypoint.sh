#!/bin/sh

sleep 10
composer install --ignore-platform-reqs --no-scripts
composer dump-autoload --optimize
php artisan migrate
php artisan storage:link
php artisan serve --host=0.0.0.0 --port=8084
