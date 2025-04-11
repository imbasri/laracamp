#!/bin/sh

# Wait for DB (optional, depends on setup)
sleep 3

# Run Laravel migration
php artisan migrate --force

# Start Supervisor (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisord.conf
