FROM php:8.2-apache
RUN apt-get update && apt-get install -y wget gnupg2 libpq-dev && docker-php-ext-install pdo pdo_pgsql
RUN a2enmod rewrite
COPY ./.env .
EXPOSE 80