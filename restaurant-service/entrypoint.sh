#!/bin/sh

composer install --ignore-platform-reqs --no-scripts
php -S 0.0.0.0:8082 -t bootstrap bootstrap/app.php