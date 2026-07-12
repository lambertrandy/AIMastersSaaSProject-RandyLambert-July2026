FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y --only-upgrade --no-install-recommends curl libcurl4 \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql \
    && a2enmod rewrite

COPY docker/web/vhost.conf /etc/apache2/sites-available/000-default.conf
