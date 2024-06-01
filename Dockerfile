FROM php:8.2-apache

# Install necessary libraries
RUN apt-get update && apt-get install -y \
    zip unzip \
    libonig-dev \
    libzip-dev \
    libicu-dev

# Install PHP extensions
RUN docker-php-ext-install \
    zip \
    intl

# Install MySQL
RUN docker-php-ext-install pdo_mysql

# Install PostgreSQL
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pgsql

# Copy Laravel application
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies
RUN composer install --no-dev --prefer-dist --no-scripts --no-autoloader

# RUN composer install
RUN composer upgrade.

# Change ownership of our applications
RUN chown -R www-data:www-data /var/www/html


# Expose port 8000
EXPOSE 80

# Adjusting Apache configurations
RUN a2enmod rewrite
COPY /docker/apache-config.conf /etc/apache2/sites-available/000-default.conf
