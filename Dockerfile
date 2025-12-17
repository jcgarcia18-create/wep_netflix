# Stage 1: Composer
FROM composer:2 as composer

# Install the mongodb PHP extension, which is required by your dependencies
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb && \
    apk del .build-deps

WORKDIR /app
COPY composer.json composer.lock ./
# Install dependencies without running scripts yet
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs --no-scripts



# Stage 3: Final application image
FROM php:8.3-fpm
WORKDIR /var/www

# Copy composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install build dependencies, runtime dependencies, install extensions, then clean up build dependencies
RUN apt-get update && apt-get install -y \
        build-essential \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libpq-dev \
        libonig-dev \
        libxml2-dev \
        nodejs \
        npm \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo_pgsql pgsql exif pcntl bcmath gd zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy application files first
COPY . .

# Copy the pre-built vendor directory
COPY --from=composer /app/vendor/ /var/www/vendor/

# Install npm dependencies
RUN npm install
RUN npm run build

# Now that all files are present, generate the optimized autoloader and run scripts
RUN composer dump-autoload --no-dev --optimize



# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]