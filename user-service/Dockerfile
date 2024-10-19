FROM php:8-alpine

COPY entrypoint.sh .

RUN apk update && apk add libpq-dev
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chmod +x entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

WORKDIR /var/www/

COPY . .

EXPOSE 8081