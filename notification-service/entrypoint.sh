#!/bin/bash

# Run migrations
composer install --no-dev --optimize-autoloader
php artisan migrate --force

# Start Apache
exec apache2-foreground