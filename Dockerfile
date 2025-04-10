FROM php:8.1-apache

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html/storage
RUN a2enmod rewrite
# Copy custom Apache config
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Enable mod_rewrite dan set DocumentRoot
RUN a2enmod rewrite && \
    sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && apache2-foreground"]
