FROM php:8.2-apache

RUN a2enmod rewrite

COPY docker/web/vhost.conf /etc/apache2/sites-available/000-default.conf
