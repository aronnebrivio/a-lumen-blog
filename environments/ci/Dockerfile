FROM aronnebrivio/php:7.4-base

# Change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN echo "xdebug.start_with_request=yes" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.discover_client_host=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
