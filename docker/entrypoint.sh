#!/bin/bash

php artisan cache:clear
php artisan route:clear
php artisan config:clear

exec docker-php-entrypoint "$@"