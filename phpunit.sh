#!/usr/bin/env bash
# Composer
composer.phar selfupdate
composer.phar install --prefer-source -n

# Tests
./vendor/bin/phpcs --standard=psr2 --ignore=vendor -n .
./vendor/bin/phpunit --verbose --debug