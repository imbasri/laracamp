#!/usr/bin/env bash
composer install
php artisan key:generate
php artisan migrate --force
php artisan storage:link
