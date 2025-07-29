FROM php:8.1-apache

# Install required dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

RUN a2enmod rewrite
RUN service apache2 restart

COPY www/ .

RUN composer install
EXPOSE 80