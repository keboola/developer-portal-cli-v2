#!/bin/bash
docker login -u="$QUAY_USERNAME" -p="$QUAY_PASSWORD" quay.io
docker tag keboola/developer-portal-cli quay.io/keboola/developer-portal-cli-v2:$TRAVIS_TAG
docker push quay.io/keboola/developer-portal-cli-v2:$TRAVIS_TAG
