FROM wordpress:6.7-php8.3-fpm

# System Deps
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libjpeg-dev libwebp-dev \
    curl git unzip \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install zip gd exif mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Redis PHP Ext
RUN pecl install redis && docker-php-ext-enable redis

# WP-CLI (Must-Have)
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# PHP Configs
RUN echo "upload_max_filesize = 128M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size = 128M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html
