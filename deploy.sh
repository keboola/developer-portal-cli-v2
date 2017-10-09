#!/bin/bash
set -e

# Deploy to Dockerhub
docker login -u="$DOCKERHUB_USERNAME" -p="$DOCKERHUB_PASSWORD" https://index.docker.io/v1/
docker tag keboola/developer-portal-cli-v2 keboola/developer-portal-cli-v2:$TRAVIS_TAG
docker tag keboola/developer-portal-cli-v2 qkeboola/developer-portal-cli-v2:latest
docker push keboola/developer-portal-cli-v2:$TRAVIS_TAG
docker push keboola/developer-portal-cli-v2:latest

# Deploy to Quay.io
docker login -u="$QUAY_USERNAME" -p="$QUAY_PASSWORD" quay.io
docker tag keboola/developer-portal-cli-v2 quay.io/keboola/developer-portal-cli-v2:$TRAVIS_TAG
docker tag keboola/developer-portal-cli-v2 quay.io/keboola/developer-portal-cli-v2:latest
docker push quay.io/keboola/developer-portal-cli-v2:$TRAVIS_TAG
docker push quay.io/keboola/developer-portal-cli-v2:latest
