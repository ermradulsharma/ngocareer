FROM php:7.4-apache

# Install base packages provided by the image
# and install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql zip gd intl mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Install dependencies (Caching layer)
# COPY composer.json composer.lock ./
# RUN composer install --no-scripts --no-autoloader

# Copy application source
# We will mount volume in docker-compose for dev, but this is good for prod builds
COPY . /var/www/html

# Install XDebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Dump autoload
# RUN composer dump-autoload --optimize

# Ownership settings for Apache
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
