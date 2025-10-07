FROM php:7.4-fpm-alpine

WORKDIR /src

RUN set -x \
    && apk update \
    && apk upgrade \
    && apk add --no-cache \
        bash \
        git \
        openssh \
        php-cli \
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

# Instalar extensões PECL compatíveis com PHP 7.4
RUN set -x \
    && apk add --no-cache --virtual .build-deps pcre-dev $PHPIZE_DEPS \
    && pecl install redis-6.0.2 xdebug-3.1.6 pcov \
    && docker-php-ext-enable redis xdebug pcov \
    && apk del -f .build-deps

# Instalar Imagick através do código fonte diretamente
RUN set -x \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && mkdir -p /usr/src/php/ext/imagick \
    && cd /usr/src/php/ext/imagick \
    && curl -fsSL https://github.com/Imagick/imagick/archive/refs/tags/3.7.0.tar.gz | tar xz --strip-components=1 \
    && phpize \
    && ./configure \
    && make \
    && make install \
    && docker-php-ext-enable imagick \
    && apk del -f .build-deps

RUN set -x \
    && curl -L https://getcomposer.org/composer.phar -o /usr/local/bin/composer \
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
