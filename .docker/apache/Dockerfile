# Use PHP 8.2 with Apache as the base image
FROM php:8.4-apache

# Set the working directory
WORKDIR /var/www/html

# Install dependencies including libonig-dev for mbstring
RUN apt-get update -y && apt-get install -y \
        sendmail \
        libpng-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libzip-dev \
        zip \
        unzip \
        curl \
        libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Now install mbstring (this will work after installing libonig-dev)
RUN docker-php-ext-install mbstring
RUN docker-php-ext-configure zip \
    && docker-php-ext-install zip
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli pdo pdo_mysql

# Configure PHP settings for file uploads and execution limits
RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 2024M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 2024M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 2024M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 30000" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_time = 30000" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_file_uploads = 1000" >> /usr/local/etc/php/conf.d/uploads.ini

# Enable Apache rewrite module
RUN a2enmod rewrite

# Create a directory for the application
RUN mkdir /app
RUN chown -R www-data:www-data /app

# Copy custom Apache vhost configuration
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Define a custom 404 error page
COPY resources/views/errors/404.blade.php /var/www/html/404.blade.php
