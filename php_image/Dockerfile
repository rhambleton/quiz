FROM php:7-fpm
RUN apt-get update && apt-get install -y \
  libfreetype6-dev \
  libpng-dev \
  libjpeg-dev
RUN docker-php-ext-configure gd --enable-gd-native-ttf --with-jpeg-dir=/usr/lib/x86_64-linux-gnu --with-png-dir=/usr/lib/x86_64-linux-gnu --with-freetype-dir=/usr/lib/x86_64-linux-gnu
RUN docker-php-ext-install gd
RUN docker-php-ext-install mysqli