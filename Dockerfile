FROM php:8.3-apache as prod

RUN apt update && apt install curl zip unzip libzip-dev libicu-dev libpq-dev -y

RUN docker-php-ext-install pdo_pgsql pdo_mysql exif zip bcmath intl

WORKDIR /var/www/html/

COPY ./ /var/www/html

# Ensure storage and bootstrap/cache directories are writable
RUN mkdir -p storage/frameworks/views storage/frameworks/sessions storage/logs \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN rm -rf tests/

RUN chown -R www-data:www-data /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite headers deflate

COPY start.sh /usr/local/bin/start

RUN chmod a+x /usr/local/bin/start

EXPOSE 80

CMD [ "/usr/local/bin/start" ]
