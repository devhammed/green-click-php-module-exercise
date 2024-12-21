# Base Stage: Common dependencies and setup
FROM php:8.2-fpm-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
        bash \
        git \
        curl \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        oniguruma-dev \
        postgresql-dev \
        mysql-client \
        icu-dev \
        zip \
        unzip

# Install PHP extensions
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg && \
    docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        intl \
        bcmath \
        gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set up working directory
WORKDIR /var/www/html

# Development Stage
FROM base AS development

WORKDIR /var/www/html

# Copy application code for development
COPY .. ./

# Retain Composer for flexibility in development
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer dependencies (including dev dependencies)
RUN composer install

# Install Node.js and NPM
RUN apk add --no-cache nodejs npm

# Install NPM dependencies
RUN npm install

# Permission fix for www-data user
RUN chown -R www-data:www-data /var/www/html

# Expose port for PHP-FPM
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]

# Production Stage
FROM base AS production

# Copy application code from development stage
COPY --from=development /var/www/html /var/www/html

# Work in the application directory
WORKDIR /var/www/html

# Install Composer dependencies (excluding dev dependencies)
RUN composer install --no-dev --optimize-autoloader

# Install NPM dependencies
RUN npm ci

# Permission fix for www-data user
RUN chown -R www-data:www-data /var/www/html

# Expose port for PHP-FPM
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
