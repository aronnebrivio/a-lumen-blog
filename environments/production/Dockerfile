FROM aronnebrivio/php:8.0-base

ENV APP_HOME /var/www/html

# Load environment variables from build args
ARG DB_HOST
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD
ARG REDIS_HOST
ARG REDIS_PORT
ARG REDIS_DATABASE
ARG REDIS_PASSWORD
ARG JWT_SECRET

ENV DB_HOST=$DB_HOST
ENV DB_DATABASE=$DB_DATABASE
ENV DB_USERNAME=$DB_USERNAME
ENV DB_PASSWORD=$DB_PASSWORD
ENV REDIS_HOST=$REDIS_HOST
ENV REDIS_PORT=$REDIS_PORT
ENV REDIS_DATABASE=$REDIS_DATABASE
ENV REDIS_PASSWORD=$REDIS_PASSWORD
ENV JWT_SECRET=$JWT_SECRET

# Copy source and install dependencies
COPY . $APP_HOME
COPY environments/production/.env .env
RUN composer install

# Run migrations
RUN php artisan migrate --force

# Clean
RUN rm -rf .git .github .vscode database environments private tests \
    .gitignore .php_cs.dist artisan captainhook.json composer.json composer.lock Dockerfile docker-compose.yml LICENSE phpunit-printer.yml phpunit.xml psalm.xml README.md

# Change ownership of our applications
RUN chown -R www-data:www-data $APP_HOME

# Start
COPY environments/production/start.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/start.sh
CMD ["start.sh"]
