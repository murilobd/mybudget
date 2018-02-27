FROM ubuntu:16.04

MAINTAINER Murilo Boareto Delefrate <murilobd@gmail.com>

RUN apt-get update \
    && apt-get install -y locales \
    && locale-gen en_US.UTF-8 pt_BR.UTF-8

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

RUN apt-get update \
    && apt-get install -y curl zip unzip git software-properties-common supervisor sqlite3 cron vim python-software-properties \
    && add-apt-repository -y ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y php7.1-fpm php7.1-cli php7.1-mcrypt php7.1-gd php7.1-mysql \
        php7.1-pgsql php7.1-imap php-memcached php7.1-mbstring php7.1-xml php7.1-curl \
        php7.1-sqlite3 php7.1-xdebug php7.1-zip \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && mkdir /run/php

# Install node.js
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get update \
    && apt-get -y install nodejs build-essential


RUN apt-get remove -y --purge software-properties-common \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY php-fpm.conf /etc/php/7.1/fpm/php-fpm.conf
COPY www.conf /etc/php/7.1/fpm/pool.d/www.conf
COPY php.ini /etc/php/7.1/fpm/php.ini

# Add laravel cron
ADD laravel_crontab /etc/cron.d/laravel

EXPOSE 9000

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy ENTRYPOINT
ADD ./starter.sh /opt/bin/starter.sh
RUN chmod u=rwx /opt/bin/starter.sh

# When launch the container, run this file
ENTRYPOINT ["/opt/bin/starter.sh"]