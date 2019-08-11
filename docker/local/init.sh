#!/bin/bash

cd /var/www/html/storage
mkdir -p app
mkdir -p framework/cache
mkdir -p framework/views
mkdir -p logs
chmod -R 777 /var/www/html/storage

if [ $XDEBUG_ENABLE -eq 0 ]; then
  rm -rf /usr/local/etc/php/conf.d/xdebug.ini
fi

cd /var/www/html
docker-php-entrypoint apache2-foreground
