# developer-portal-php-client-v2
PHP Client for Keboola Developer Portal

[![Build Status](https://travis-ci.com/keboola/developer-portal-cli-v2.svg?branch=master)](https://travis-ci.com/keboola/developer-portal-cli-v2)
[![Docker Repository on Quay](https://quay.io/repository/keboola/developer-portal-cli-v2/status "Docker Repository on Quay")](https://quay.io/repository/keboola/developer-portal-cli-v2)

## Usage

```
$ export KBC_DEVELOPERPORTAL_USERNAME=myuser
$ export KBC_DEVELOPERPORTAL_PASSWORD=mypassword
$ export KBC_DEVELOPERPORTAL_URL=https://apps-api.keboola.com # optional
$ docker pull quay.io/keboola/developer-portal-cli-v2:latest
...
$ docker run --rm -e KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD quay.io/keboola/developer-portal-cli-v2:latest ecr:get-login keboola keboola.my-application
docker login -u AWS -p password 123456.dkr.ecr.us-east-1.amazonaws.com

$ eval $(docker run --rm -e KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD quay.io/keboola/developer-portal-cli-v2:latest ecr:get-login keboola keboola.my-application)
Login Succeeded

$ docker run --rm  -e KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD quay.io/keboola/developer-portal-cli-v2:latest ecr:get-repository keboola keboola.my-application
123456.dkr.ecr.us-east-1.amazonaws.com

$ export REPOSITORY=`docker run --rm  -e KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD quay.io/keboola/developer-portal-cli-v2:latest ecr:get-repository keboola keboola.my-application`

$ echo $REPOSITORY
123456.dkr.ecr.us-east-1.amazonaws.com/developer-portal-v2/keboola.my-application
```

To update application properties, use the `update-app-property` command. Properties are updated one at a time. 
 
```
$ docker run --rm -e KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD quay.io/keboola/developer-portal-cli-v2:latest update-app-property keboola keboola.my-application shortDescription --value="My description"
Updating application keboola / keboola.my-application:
{
    "shortDescription": "My description"
}
```

Property value can be passed directly or read from file. To read property rom file, use the `--value-from-file` option. 
In that case, you also have to map the file with the Docker `--volume` option.

```
$ docker run --rm --volume=localPath/localFile:/tmp/localFile -e KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD quay.io/keboola/developer-portal-cli-v2:latest update-app-property keboola-test keboola keboola.my-application longDescription --value-from-file=/tmp/localFile
{
    "longDescription": "...."
}
```

You can also map the entire directory with the Docker `--volume` option.

```
$ docker run --rm --volume=localPath:/data/ -e KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD quay.io/keboola/developer-portal-cli-v2:latest update-app-property keboola-test keboola keboola.my-application longDescription --value-from-file=/data/localFile
{
    "longDescription": "...."
}
```

Some properties (e.g. `configurationSchema`) require that an object is passed as a value. In that case, you
have to provide a valid JSON string in either the `--value` or `--value-from-file` options.

```
$ docker run --rm -e KBC_DEVELOPERPORTAL_USERNAME -e KBC_DEVELOPERPORTAL_PASSWORD quay.io/keboola/developer-portal-cli-v2:latest update-app-property keboola keboola.my-application configurationSchema --value="{\"a\":\"b\"}"
Updating application keboola / keboola.my-application:
{
    "configurationSchema": {
        "a": "b"
    }
}
```

Notice that the string `{\"a\":\"b\"}` was parsed into a Javascript object. 

You can also pass
```
-e KBC_DEVELOPERPORTAL_URL
```

to the `docker run` commands above if you wan to use custom API URL. 

Repository is also mirrored to dockerhub:

```
docker pull keboola/developer-portal-cli-v2:latest
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
KBC_DEVELOPERPORTAL_URL= # optional
KBC_DEVELOPERPORTAL_TEST_VENDOR=
KBC_DEVELOPERPORTAL_TEST_APP=
```

### Run Tests

```
docker-compose run --rm tests
```
