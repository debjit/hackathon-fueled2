#!/usr/bin/env bash
sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT:-80}/g" /etc/apache2/sites-enabled/*
php /var/www/html/artisan queue:work --verbose --tries=3 &
apachectl -D FOREGROUND
