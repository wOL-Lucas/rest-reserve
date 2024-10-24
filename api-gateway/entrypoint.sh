#!/bin/sh

composer install --ignore-platform-reqs --no-scripts
composer dump-autoload --optimize
php artisan serve --host=0.0.0.0 --port=8080