# developer-portal-php-client-v2
PHP Client for Keboola Developer Portal

[![Build Status](https://travis-ci.org/keboola/developer-portal-cli-v2.svg?branch=master)](https://travis-ci.org/keboola/developer-portal-cli-v2)
[![Docker Repository on Quay](https://quay.io/repository/keboola/developer-portal-cli-v2/status "Docker Repository on Quay")](https://quay.io/repository/keboola/developer-portal-cli-v2)

## Usage

```
$ export KBC_DEVELOPERPORTAL_USERNAME=myuser
$ export KBC_DEVELOPERPORTAL_PASSWORD=mypassword
$ export KBC_DEVELOPERPORTAL_URL=https://apps.keboola.com
$ docker pull quay.io/keboola/developer-portal-cli-v2:latest
...
$ docker run --rm -e KBC_DEVELOPERPORTAL_USERNAME=$KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD=$KBC_DEVELOPERPORTAL_PASSWORD -e KBC_DEVELOPERPORTAL_URL=$KBC_DEVELOPERPORTAL_URL quay.io/keboola/developer-portal-cli-v2:latest ecr:get-login keboola keboola.my-application
docker login -u AWS -p password 123456.dkr.ecr.us-east-1.amazonaws.com

$ eval $(docker run --rm -e KBC_DEVELOPERPORTAL_USERNAME=$KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD=$KBC_DEVELOPERPORTAL_PASSWORD -e KBC_DEVELOPERPORTAL_URL=$KBC_DEVELOPERPORTAL_URL quay.io/keboola/developer-portal-cli-v2:latest ecr:get-login keboola keboola.my-application)
Login Succeeded

$ docker run --rm  -e KBC_DEVELOPERPORTAL_USERNAME=$KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD=$KBC_DEVELOPERPORTAL_PASSWORD -e KBC_DEVELOPERPORTAL_URL=$KBC_DEVELOPERPORTAL_URL quay.io/keboola/developer-portal-cli-v2:latest ecr:get-repository keboola keboola.my-application
123456.dkr.ecr.us-east-1.amazonaws.com

$ export REPOSITORY=`docker run --rm  -e KBC_DEVELOPERPORTAL_USERNAME=$KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD=$KBC_DEVELOPERPORTAL_PASSWORD -e KBC_DEVELOPERPORTAL_URL=$KBC_DEVELOPERPORTAL_URL quay.io/keboola/developer-portal-cli-v2:latest ecr:get-repository keboola keboola.my-application`

$ echo $REPOSITORY
123456.dkr.ecr.us-east-1.amazonaws.com/developer-portal-v2/keboola.my-application

```

### Help

```
docker run --rm quay.io/keboola/developer-portal-cli-v2:latest
```

## Development

### Build

```
docker-compose build
```


### Environment

```
$ cat .env
KBC_DEVELOPERPORTAL_USERNAME=
KBC_DEVELOPERPORTAL_PASSWORD=
KBC_DEVELOPERPORTAL_URL=
KBC_DEVELOPERPORTAL_TEST_VENDOR=
KBC_DEVELOPERPORTAL_TEST_APP=
```

### Run Tests

```
docker-compose run --rm tests
```
