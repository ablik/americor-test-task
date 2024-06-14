# Dockerfile

FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    zip \
    && docker-php-ext-install pdo_mysql intl mbstring zip curl opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create and set permissions for the working directory
RUN mkdir -p /var/www && chown -R www-data:www-data /var/www

# Set working directory
WORKDIR /var/www

# Switch to the www-data user
USER www-data

# Copy project files
COPY --chown=www-data:www-data .. .

# Install Symfony and project dependencies
RUN composer install --no-scripts --no-interaction

# Re-enable root user to perform additional setup
USER root

# Create cache and log directories and set permissions
RUN mkdir -p var/cache var/log && chown -R www-data:www-data var/cache var/log

# Switch back to www-data user for runtime
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]