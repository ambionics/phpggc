FROM php:7.4-cli-alpine AS builder

COPY . /phpggc

WORKDIR /phpggc

RUN chmod +x phpggc

ENTRYPOINT ["/phpggc/phpggc"]