FROM php:8-alpine

WORKDIR /var/www/

RUN apk update && apk add libpq-dev
RUN docker-php-ext-install bcmath pgsql pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .
COPY entrypoint.sh .
RUN chmod +x ./entrypoint.sh

ENTRYPOINT ["./entrypoint.sh"]

EXPOSE 8080
