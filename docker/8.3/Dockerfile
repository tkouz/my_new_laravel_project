ARG WWWGROUP
# Use the official PHP 8.3 FPM Alpine image as base
FROM php:8.3-fpm-alpine

# Set working directory inside the container
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
# These are common extensions required for Laravel
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    libwebp-dev \
    libxml2-dev \
    postgresql-dev \
    sqlite-dev \
    oniguruma-dev \
    icu-dev \
    gmp-dev \
    imagemagick-dev \
    freetype-dev \
    libjpeg \
    libwebp \
    libzip \
    libxml2 \
    postgresql-libs \
    sqlite-libs \
    oniguruma \
    icu \
    gmp \
    imagemagick \
    freetype \
    nginx # Nginx is installed here, which means Sail uses Nginx, not Apache.

# Install PHP extensions
# Use docker-php-ext-install for common extensions
RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    gmp \
    opcache \
    sockets \
    mysqli \
    pdo_pgsql \
    pdo_sqlite \
    xml \
    mbstring

# Configure PHP-FPM
# Copy PHP-FPM configuration file
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./sails/8.3/php-fpm.conf /etc/php83/php-fpm.d/www.conf # Sail's PHP-FPM config
COPY ./sails/8.3/php.ini /etc/php83/conf.d/99-sail.ini # Sail's PHP INI config
COPY ./sails/8.3/nginx.conf /etc/nginx/http.d/default.conf # Sail's Nginx config

# Set permissions for www-data user and group
# This is crucial for file access
RUN addgroup -g ${WWWGROUP} sail \
    && adduser -G sail -u 1000 -D sail \
    && chown -R sail:sail /var/www/html

# Expose port 80 for the web server
EXPOSE 80

# Start PHP-FPM and Nginx
CMD ["sh", "-c", "php-fpm && nginx -g 'daemon off;'"]
