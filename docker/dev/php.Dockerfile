FROM php:8.4.27-fpm-alpine

WORKDIR /src

RUN set -x \
    && apk update \
    && apk upgrade \
    && apk add --no-cache \
        bash \
        git \
        openssh \
        zlib-dev \
        freetype-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        libzip-dev \
        zip \
        mysql-client \
        mariadb-connector-c-dev \
        libwebp-dev \
        linux-headers \
        icu-dev \
        icu-libs \
        imagemagick \
        imagemagick-dev \
        libgomp

RUN set -x \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install opcache bcmath exif pdo pdo_mysql zip gd intl pcntl

RUN set -x \
    && apk add --no-cache --virtual .build-deps pcre-dev $PHPIZE_DEPS \
    && pecl install redis-6.3.0 xdebug-3.5.3 pcov-1.0.12 imagick-3.8.1 \
    && docker-php-ext-enable redis xdebug pcov imagick \
    && apk del -f .build-deps

RUN set -x \
    && curl -L https://getcomposer.org/download/latest-stable/composer.phar -o /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

COPY . /src/

RUN set -x \
    && mkdir -p /src/storage/logs \
    && mkdir -p /src/storage/framework/cache/data \
    && mkdir -p /src/storage/framework/sessions \
    && mkdir -p /src/storage/framework/views \
    && chmod -R 777 /src/storage \
    && mkdir -p /tmp/storage \
    && ln -sf /src/storage/logs /tmp/storage/logs \
    && ln -sf /src/storage/framework /tmp/storage/framework \
    && chmod -R 777 /tmp/storage
