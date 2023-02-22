FROM php:7.4-fpm-alpine 

# Install Composer.
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www/data 

COPY ./src .

# Create a group and user
RUN addgroup -g 1000 quangnm

RUN adduser -D -u 1000 quangnm -G quangnm

USER quangnm

