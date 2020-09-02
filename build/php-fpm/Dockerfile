FROM php:7.3.1-fpm-stretch

RUN apt-get update && apt-get install -y libmemcached-dev zlib1g-dev libssl-dev wget curl vim
RUN apt-get install -y git zip unzip jpegoptim optipng pngquant gifsicle

RUN apt-get update && apt-get install -y libpng-dev libjpeg62-turbo-dev libfreetype6-dev

RUN docker-php-ext-install gd mbstring bcmath pdo pdo_mysql

WORKDIR /usr/local/etc/php/conf.d/

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html/trufla
