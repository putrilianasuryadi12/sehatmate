# Dockerfile for Laravel Application

# Stage 1: Build Laravel with Composer
FROM composer:2 AS builder
WORKDIR /app
# RUN composer create-project --prefer-dist laravel/laravel .

# Stage 2: Setup PHP runtime
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
 && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd xml

# Copy built application from builder stage
WORKDIR /var/www
COPY . /app /var/www

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Set permissions for storage and bootstrap cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose application port
EXPOSE 8000

# Default command to run the application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
