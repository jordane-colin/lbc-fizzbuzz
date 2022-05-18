FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl bcmath gd

RUN pecl install mongodb-1.8.0 && docker-php-ext-enable mongodb

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
ADD . /var/www
RUN chown -R www-data:www-data /var/www
COPY --chown=www-data:www-data  . /var/www
USER $user

# copy all of the file in folder to /src
COPY . /var/www
WORKDIR /var/www


RUN composer update
RUN composer dump-autoload

ADD .env.example /var/www/.env
RUN chmod -R 777 storage

EXPOSE 9000
