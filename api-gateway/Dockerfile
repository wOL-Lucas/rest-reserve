FROM php:8-alpine

WORKDIR /var/www/

RUN apk add --no-cache \
    libcurl \
    sqlite \
    openssl-dev \
    linux-headers \
    musl-dev \
    postgresql-dev \
    && docker-php-ext-install bcmath pgsql pdo_pgsql sockets \
    && apk del openssl-dev musl-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

COPY entrypoint.sh .
RUN chmod +x ./entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["./entrypoint.sh"]
