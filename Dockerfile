FROM php:8.4
RUN  --mount=type=bind,from=mlocati/php-extension-installer:latest,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
    install-php-extensions @composer
WORKDIR /app
COPY . .
RUN composer install
RUN vendor/bin/phpunit  tests/Test.php


