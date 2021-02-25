FROM php:7.4-apache

# Install required linux libraries
RUN apt-get update && apt-get install -y zip unzip

# Install gd-extension for html2pdf-package
RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install pdo_mysql

# Enable required Apache-Modules
RUN a2enmod rewrite

# Copy Apache-Configuration for Laravel
COPY docker/apache2-default-site.conf /etc/apache2/sites-available/000-default.conf

# Use the default production configuration for PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy all relevant files for production
WORKDIR /var/www/html
COPY . .
COPY docker/.env.docker ./.env

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && php composer-setup.php && php -r "unlink('composer-setup.php');"

# Install dependencies
RUN php composer.phar install --no-dev --optimize-autoloader --no-suggest --no-progress

# Create all laravel provided caches to speed up the application
# Config-Cache will be created during the container start-up, since we need to also
# cache environment variables provided on runtime 
RUN php artisan optimize \
    && php artisan route:cache \
    && php artisan view:cache

# Change owner of apache/php writable dirs to www-data 
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/public /var/www/html/bootstrap/cache

# Allow execution of startup script for builds done on linux
RUN chmod +x docker/startup-script.sh

CMD [ "./docker/startup-script.sh" ]