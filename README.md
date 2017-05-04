# developer-portal-php-client-v2
PHP Client for Keboola Developer Portal

## Usage

```
$ export KBC_DEVELOPERPORTAL_USERNAME=myuser
$ export KBC_DEVELOPERPORTAL_PASSWORD=mypassword
$ export KBC_DEVELOPERPORTAL_URL=https://apps.keboola.com
$ docker pull quay.io/keboola/developer-portal-cli-v2:latest
...
$ docker run --rm quay.io/keboola/developer-portal-cli-v2:latest /bin/cli ecr:get-login
docker login -u AWS -p password 123456.dkr.ecr.us-east-1.amazonaws.com
$ docker run --rm quay.io/keboola/developer-portal-cli-v2:latest /bin/cli ecr:get-repository keboola keboola.my-application
developer-portal/keboola-my-application
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
