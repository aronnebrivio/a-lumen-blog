FROM php:7.4-apache

# Install PHP and composer dependencies
RUN apt-get update
RUN apt-get install -y git curl libmcrypt-dev libjpeg-dev libpng-dev libonig-dev libfreetype6-dev libbz2-dev libzip-dev

ENV APP_HOME /var/www/html

# Change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Apache config
RUN sed -i -e "s/html/html\/public/g" /etc/apache2/sites-enabled/000-default.conf

# mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# Start with base php config, then add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install \
    opcache \
    pdo_mysql \
    mysqli \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Load environment variables from build args
ARG DB_HOST
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD
ENV DB_HOST=$DB_HOST
ENV DB_DATABASE=$DB_DATABASE
ENV DB_USERNAME=$DB_USERNAME
ENV DB_PASSWORD=$DB_PASSWORD

# Copy source and install dependencies
COPY . $APP_HOME
RUN mv environments/production/.env .env
RUN composer install

# Run migrations
RUN php artisan migrate --force

# Clean
RUN rm -rf .github .vscode database environments private tests \
    .dockerignore .gitignore .php_cs.dist artisan captainhook.json Dockerfile docker-compose.yml phpunit.xml

# Change ownership of our applications
RUN chown -R www-data:www-data $APP_HOME

# Start Apache
COPY environments/production/run-apache2.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/run-apache2.sh
CMD ["run-apache2.sh"]
