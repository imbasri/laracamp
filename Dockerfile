FROM php:8.1-apache@sha256:1234567890abcdef1234567890abcdef1234567890abcdef1234567890abcdef

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Copy files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Apache configuration
RUN echo "<VirtualHost *:80>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot /var/www/html/public\n\n\
    <Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    DirectoryIndex index.php\n\
    </Directory>\n\
    ErrorLog \${APACHE_LOG_DIR}/error.log\n\
    CustomLog \${APACHE_LOG_DIR}/access.log combined\n\
    </VirtualHost>" > /etc/apache2/sites-available/000-default.conf
# Generate key jika tidak ada
RUN if [ -z "$(grep '^APP_KEY=base64:' .env)" ]; then \
    php artisan key:generate --force; \
    fi
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 storage bootstrap/cache
RUN echo "Options +Indexes +FollowSymLinks +ExecCGI" > /var/www/html/public/.htaccess
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN apt-get install -y tree && tree -L 3 /var/www/html
RUN php artisan route:list
CMD ["apache2-foreground"]
