FROM php:8.0.5-fpm

WORKDIR /var/www/html/

RUN pear config-set php_ini "./php.ini"

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install system dependencies
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libssl-dev \

    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

ENV TZ=Asia/Jakarta
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY . .

RUN composer install --optimize-autoloader --no-dev
