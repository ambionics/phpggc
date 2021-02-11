FROM php:7.4-cli-alpine AS builder

COPY . /phpggc

WORKDIR /phpggc

RUN chmod +x phpggc && echo "phar.readonly=0" > $PHP_INI_DIR/php.ini

ENTRYPOINT ["/phpggc/phpggc"]
