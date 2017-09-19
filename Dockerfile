FROM php:7.1-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY php-prod.ini /usr/local/etc/php/php.ini
COPY . /code

WORKDIR /code

RUN apk add --no-cache wget git unzip \
  && ./composer.sh \
  && rm composer.sh \
  && mv composer.phar /usr/local/bin/composer \
  && composer install --no-interaction \
  && apk del wget git unzip

ENTRYPOINT ["/code/bin/cli"]
