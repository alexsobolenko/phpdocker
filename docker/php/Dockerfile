FROM phpdockerio/php:8.0-fpm
WORKDIR "/var/www/html"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        php8.0-pgsql; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
