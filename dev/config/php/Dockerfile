FROM php:8.2-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev libonig-dev libzip-dev

RUN docker-php-ext-install zip

RUN apt-get update && apt-get upgrade -y \
    g++ \
    libc-client-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libkrb5-dev \
    libmagickwand-dev \
    libmemcached-dev \
    libpng-dev \
    libpq-dev \
    libssl-dev \
    libssl-doc \
    libsasl2-dev \
    zlib1g-dev \
    && docker-php-ext-install \
    bz2 \
    iconv \
    mbstring \
    mysqli \
    pgsql \
    pdo_mysql \
    pdo_pgsql \
    soap \
    zip \

RUN yes '' | pecl install imagick && docker-php-ext-enable imagick

RUN yes '' | pecl install xdebug-3.2.1 && docker-php-ext-enable xdebug

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

RUN docker-php-ext-configure intl  \
    && docker-php-ext-install intl

RUN apt-get autoremove -y --purge \
    && apt-get clean \
    && rm -Rf /tmp/*

RUN apt-get install -y libgmp-dev bash poppler-utils unzip graphviz libssl-dev libpcre3 libpcre3-dev\
	&& ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h \
	&& docker-php-ext-install -j$(nproc) \
		gmp \
		bcmath

RUN apt-get update && apt-get --force-yes -y install bash poppler-utils

RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

RUN docker-php-ext-configure gd  --with-jpeg --with-freetype
RUN docker-php-ext-install -j$(nproc) gd


RUN apt-get update && apt-get install -y nodejs

RUN docker-php-ext-install sockets && docker-php-ext-enable sockets

RUN docker-php-ext-install sockets && docker-php-ext-enable sockets


RUN apt-get update && apt-get install -y libengine-gost-openssl1.1

RUN yes '' | pecl install pcov && docker-php-ext-enable pcov

RUN apt-get update && apt-get install -y ghostscript

RUN apt-get update && apt-get install -y git