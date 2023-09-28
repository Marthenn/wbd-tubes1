FROM php:8.2-apache
# RUN apt-get update && \
#     apt-get install -y wget gnupg2 libpq5 libpq-dev && docker-php-ext-install pdo pdo_pgsql
RUN apt-get update && apt-get install -y wget gnupg2 libpq-dev && docker-php-ext-install pdo pdo_pgsql
RUN echo "deb https://apt.postgresql.org/pub/repos/apt focal-pgdg main" > /etc/apt/sources.list.d/pgdg.list
RUN wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add -
RUN apt-get update
RUN apt-get -y install postgresql-client-9.6
RUN a2enmod rewrite
EXPOSE 80