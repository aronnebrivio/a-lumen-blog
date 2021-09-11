FROM composer:latest as build
WORKDIR /app
COPY . /app
RUN composer install

FROM aronnebrivio/php:8.0-base
EXPOSE 80
COPY --from=build /app /var/www/html

RUN php /var/www/html/artisan jwt:secret
