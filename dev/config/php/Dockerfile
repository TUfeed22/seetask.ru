FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
  postgresql-server-dev-all \
  curl \
  wget \
  git \
  sudo \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpq-dev \
  libmcrypt-dev \
  libzip-dev \
  && docker-php-ext-install iconv pdo pdo_pgsql zip \
  && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer