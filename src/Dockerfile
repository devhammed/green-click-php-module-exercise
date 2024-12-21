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
    icu-dev \
    bash \
    git \
    curl \
    unzip

RUN docker-php-ext-install pdo_mysql gd zip intl

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

COPY . .

RUN chown -R www-data:www-data /var/www

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install &&  \
    npm install &&  \
    npm run build &&  \
    php artisan key:generate &&  \
    chown -R www-data:www-data /var/www

EXPOSE 59000

ENTRYPOINT ["composer", "run", "dev"]
