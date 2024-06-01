FROM php:8.3-apache as prod

RUN apt update && apt install curl zip unzip libzip-dev libicu-dev libpq-dev -y

RUN docker-php-ext-install pdo_pgsql exif zip bcmath intl

WORKDIR /var/www/html/

COPY ./ /var/www/html

RUN mkdir storage/frameworks/views -p 
RUN mkdir storage/frameworks/sessions -p
RUN mkdir storage/logs -p 

RUN rm -rf tests/

RUN chown -R www-data:www-data /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


EXPOSE 80

RUN a2enmod rewrite headers deflate

COPY start.sh /usr/local/bin/start


CMD [ "/usr/local/bin/start" ]



