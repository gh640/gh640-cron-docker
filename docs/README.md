# `gh640-cron-docker`

This is a tiny WordPress plugin which prevents WordPress automatic update from
failing when run in a Docker container.

WordPress doesn't recognize the own domain correctly if port fowarding is enabled for different ports when run in a Docker container:

```yaml
version: "3"

services:
  web:
    image: wordpress:latest
    ports:
      - "8000:80"
```

The automatic update triggered in the WP Cron fails if the own domain is not correct. A sample error message is:

> cURL error 7: Failed to connect to localhost port 8000 Connection refused

## Usage

Install and activate the plugin and set up the following 2 environment variables:

- `DOCKER_HTTP_PORT_GUEST`
- `DOCKER_HTTP_PORT_HOST`

Here is a simple example of `docker-compose.yml`:

```yaml
version: "3"

services:
  web:
    image: wordpress:latest
    environment:
      DOCKER_HTTP_PORT_GUEST: 80
      DOCKER_HTTP_PORT_HOST: 8000
    ports:
      - "8000:80"
```

## Tested on

- WordPress 5.3.2
- PHP 7.3
