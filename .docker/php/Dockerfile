FROM php:8.1-fpm

RUN apt update && apt install -y zlib1g-dev libpng-dev libicu-dev libzip-dev openssh-client
RUN docker-php-ext-install \
    bcmath \
    gd \
    intl \
    opcache \
    pdo_mysql \
    zip

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN groupadd -g 1000 app
RUN useradd -d /home/app -s /bin/bash -u 1000 -g 1000 app
RUN mkdir /home/app
RUN chown -R app:app /home/app

USER app:app

WORKDIR /var/www/project