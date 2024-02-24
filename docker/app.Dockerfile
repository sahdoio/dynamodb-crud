FROM php:8.2.15-fpm

WORKDIR /var/www

RUN apt-get update && apt-get -f -y install build-essential unzip wget

RUN apt-get install -y \
   libpng-dev \
   libjpeg62-turbo-dev \
   libfreetype6-dev \
   libzip-dev \
   locales \
   zip \
   vim \
   unzip \
   git \
   curl \
   libmcrypt-dev \
   freetds-bin \
   freetds-dev \
   freetds-common \
   libxml2-dev \
   libxslt-dev \
   libaio1 \
   libmcrypt-dev \
   libreadline-dev

RUN docker-php-ext-install \
   pdo_mysql \
   gd \
   zip \
   calendar \
   exif \
   gettext \
   pcntl mysqli \
   shmop \
   soap bcmath \
   sockets \
   sysvmsg \
   sysvsem \
   sysvshm \
   xsl \
   opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www
