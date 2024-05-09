FROM php:8.2.3-fpm

ARG user
ARG uid

ENV APACHE_DOCUMENT_ROOT="/var/www/html/public"

WORKDIR /var/www

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo_mysql zip exif pcntl gd memcached pdo pdo_pgsql pgsql

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    lua-zlib-dev \
    libmemcached-dev \
    librdkafka-dev

RUN pecl install -o -f redis && rm -rf /tmp/pear
RUN docker-php-ext-configure opcache --enable-opcache
RUN docker-php-ext-enable redis

ENV LIBRDKAFKA_VERSION=2.2.0
ENV EXT_RDKAFKA_VERSION=6.0.3

RUN git clone --depth 1 --branch v$LIBRDKAFKA_VERSION https://github.com/edenhill/librdkafka.git /tmp/librdkafka && \
  cd /tmp/librdkafka/ && \
  ./configure && \
  make && \
  make install

RUN pecl channel-update pecl.php.net \
    && pecl install rdkafka-$EXT_RDKAFKA_VERSION \
    && docker-php-ext-enable rdkafka \
    && rm -rf /librdkafka

# Get latest Composer
COPY --from=composer:2.5.4 /usr/bin/composer /usr/bin/composer

ENV NOVA_USERNAME="zenkilies@gmail.com"
ENV NOVA_LICENSE_KEY="cboQQJp2wheZPsDgoyuBLPU6VWygaLovpEg32C0WOo7JNuUCe0"

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


WORKDIR /var/www

COPY . .

RUN composer config http-basic.nova.laravel.com $NOVA_USERNAME $NOVA_LICENSE_KEY
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction --ignore-platform-req=ext-gd

# Set working directory
WORKDIR /var/www
USER $user


