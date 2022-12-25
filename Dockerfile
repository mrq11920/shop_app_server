FROM php:7.4-fpm-alpine 

# Install Composer.
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKdIR /var/www/data 

COPY ./src .

# Create a group and user
RUN addgroup -g 1000 appgroup

RUN adduser -D -u 1000 appuser -G appgroup

USER appuser

