#!/bin/sh

set -e

# Tests
./vendor/bin/phpcs --standard=psr2 --ignore=vendor -n .
./vendor/bin/phpunit --verbose --debug
