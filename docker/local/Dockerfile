FROM php:7.4-apache

RUN apt-get update

# 1. development packages
RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    nano \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    g++ \
    pkg-config \
    build-essential \
    libmemcached-dev \
    libmemcached-tools

# 2. apache configs + document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# 4. start with base php config, then add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install \
    gd \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    zip

# 5. composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. redis
RUN pecl install redis \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini

# 7. configuring xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
ENV XDEBUG_MODE=off
ENV XDEBUG_START_WITH_REQUEST=yes
ENV XDEBUG_DISCOVER_CLIENT_HOST=1
