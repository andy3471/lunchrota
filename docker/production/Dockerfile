FROM dunglas/frankenphp

RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    redis \
    pdo_pgsql \
    zip \
    gd

# Add PHP configuration to suppress deprecation warnings
RUN echo "error_reporting = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY . /app

CMD ["php", "artisan", "octane:frankenphp"]