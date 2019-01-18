FROM php:7.2-cli
RUN apt-get update \
    && apt-get install -y git zlib1g-dev unzip autoconf

# core extensions
RUN docker-php-ext-enable opcache
RUN docker-php-ext-install bcmath

# apcu
RUN pecl install apcu \
    && docker-php-ext-enable apcu

# xdebug
# we do not enable by default the extension because this is done in php/php-ini-overrides.ini when needed
RUN pecl install xdebug-2.6.0

# composer
ENV COMPOSER_HOME /var/www/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require hirak/prestissimo
RUN composer global require maglnet/composer-require-checker
RUN chmod -R 777 $COMPOSER_HOME

WORKDIR /app
