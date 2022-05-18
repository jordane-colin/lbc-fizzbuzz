FROM php:7.4-fpm

WORKDIR /var/www

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
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN pecl install mongodb-1.8.0 && docker-php-ext-enable mongodb

RUN usermod -a -G sudo www-data && \
    echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
ADD . /var/www
RUN chown -R www-data:www-data /var/www

ADD .env.example /var/www/.env

USER www-data

RUN composer install

EXPOSE 9000
