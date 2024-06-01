FROM php:8.3-apache as prod

RUN apt update && apt install curl zip unzip libzip-dev libicu-dev libpq-dev -y

RUN docker-php-ext-install pdo_pgsql pdo_mysql exif zip bcmath intl

WORKDIR /var/www/html/

COPY ./ /var/www/html

RUN mkdir storage/frameworks/views -p
RUN mkdir storage/frameworks/sessions -p
RUN mkdir storage/logs -p

RUN rm -rf tests/

RUN chown -R www-data:www-data /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf


RUN a2enmod rewrite headers deflate

COPY start.sh /usr/local/bin/start

RUN chmod a+x /usr/local/bin/start

RUN chmod -R 755 /var/www/html/storage /var/www/html/vendor /var/www/html/public

EXPOSE 80


# CMD [ "/usr/local/bin/start" ]



