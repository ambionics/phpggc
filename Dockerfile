FROM php:8.1-cli-alpine AS builder

RUN apk add python3 py3-pip curl

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN alias composer='php /usr/bin/composer'

RUN pip install rich

COPY . /phpggc

WORKDIR /phpggc

RUN chmod +x phpggc && echo "phar.readonly=0" > $PHP_INI_DIR/php.ini

ENTRYPOINT ["/phpggc/phpggc"]
