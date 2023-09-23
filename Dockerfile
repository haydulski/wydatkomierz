# Use the official PHP 8.1 image
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libsqlite3-dev \
    nodejs \
    npm \
    curl 

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy the Laravel application files into the container
COPY . .

RUN chown -R www-data:www-data public storage bootstrap/cache

RUN npm install -g n && n 16.16.0

RUN npm install && npm run build

# Install PHP extensions and Laravel dependencies
RUN docker-php-ext-install pdo pdo_sqlite && \
    composer install --no-interaction --no-progress

RUN php artisan key:generate
RUN php artisan migrate:fresh --seed

# Expose port 9000 to connect to PHP-FPM
EXPOSE 9000

ENTRYPOINT ["docker/entrypoint.sh"]

CMD ["php-fpm"]