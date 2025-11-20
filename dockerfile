FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

COPY . .

ENV WEBROOT /var/www/html/public
ENV SKIP_COMPOSER 1
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

RUN composer install --no-dev --optimize-autoloader
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

CMD ["/start.sh"]
