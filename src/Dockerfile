FROM php:8.3-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache \
    nodejs \
    npm \
    mysql-client \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    libzip-dev \
    libxml2-dev \
    bash \
    git \
    curl \
    unzip

RUN docker-php-ext-install pdo_mysql gd zip intl

COPY . .

RUN chown -R www-data:www-data /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

RUN npm install

EXPOSE 8080

ENTRYPOINT ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
