FROM php:8.1-fpm-alpine

# Install OS packages
RUN apk add --no-cache nginx supervisor curl git unzip libzip-dev oniguruma-dev \
    freetype-dev libpng-dev libjpeg-turbo-dev libxml2-dev zlib-dev bash

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel project
COPY . .

# Install Laravel deps
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Copy nginx config
COPY nginx.conf /etc/nginx/http.d/default.conf

# Copy supervisord config
COPY supervisord.conf /etc/supervisord.conf

# Expose port 80 (HTTP)
EXPOSE 80

# Start Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
