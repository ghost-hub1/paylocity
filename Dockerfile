FROM richarvey/nginx-php-fpm:latest

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]


FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y unzip curl libzip-dev && docker-php-ext-install zip

# Set workdir
WORKDIR /app

# Copy files
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Install Laravel dependencies
RUN composer install --no-interaction --optimize-autoloader

# Expose port and serve app
CMD php -S 0.0.0.0:8080 -t public
