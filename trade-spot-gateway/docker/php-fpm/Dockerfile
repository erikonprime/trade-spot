FROM php:8.2-fpm

RUN apt update \
    && apt install -y zlib1g-dev libssl-dev g++ git libicu-dev zip libzip-dev zip libz-dev libmemcached-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu memcached \
    && docker-php-ext-enable apcu memcached \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
RUN chmod a+x /usr/local/bin/symfony

RUN groupadd -o -g 1001 app \
    && useradd -o -u 1001 -g app -G root -d /var/www/app app

USER 1001:1001
