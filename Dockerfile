FROM php:7.1.3-fpm-alpine
MAINTAINER David Nuñez <dnunez24@gmail.com>

ENV COMPOSER_HOME /var/www/html/.composer
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

RUN apk add --no-cache --virtual .build-deps \
    autoconf \
    build-base \
    coreutils \
    gnupg \
    icu-dev \
    imagemagick-dev \
    libmcrypt-dev \
    libxml2-dev \
    pcre-dev \
    zlib-dev \
  && apk add --no-cache \
    icu-libs \
    imagemagick \
    git \
    libmcrypt \
    libxml2 \
    libtool

RUN apk add \
    --no-cache \
    --repository http://dl-3.alpinelinux.org/alpine/edge/testing \
    gnu-libiconv

RUN NPROC=$(getconf _NPROCESSORS_ONLN) \
  && docker-php-ext-install -j$NPROC \
    dom \
    iconv \
    intl \
    mcrypt \
    opcache \
    pdo_mysql \
    zip \
  && printf "\n" | pecl install -o \
    imagick \
    redis \
  && docker-php-ext-enable \
    imagick \
    redis

RUN echo "$(curl https://composer.github.io/installer.sig)  composer-setup.php" > composer-setup.php.sig \
  && curl -o composer-setup.php https://getcomposer.org/installer \
  && sha384sum -c composer-setup.php.sig \
  && php composer-setup.php \
    --install-dir=/usr/local/bin \
    --filename=composer \
  && rm composer-setup.php* \
  && mkdir -p /var/www/html \
  && apk del .build-deps

COPY . /var/www/html

RUN composer install \
      --no-interaction \
      --optimize-autoloader \
      --prefer-dist \
    && find /var/www/html -type f -exec chmod g+w {} \; \
    && find /var/www/html -type d -exec chmod g+ws {} \; \
    && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html
USER www-data
