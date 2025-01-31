# Roar to Speakers
A simple web program that allows speakers to receive real-time feedback from the audience.

## Description

The inspiration comes from a moment of self-reflection. During my speech, I want the audience to feel free to point out whenever they feel my excessive masculinity at any given moment. So, I write this program. It consists of two pages:

- website.../index.php, which is accessible to all audience who can submit their feedback, or simply let out a ROAR at any time.
- website.../result.php, which is only accessible to the speaker and displays the received messages in real-time. The page can be shown on the conference's screen or just on a pad at the table.

## Getting Started

### Dependencies

* A Web Server with PHP and PHP-Redis support.
* A Redis Server
* Or, the program can be built and deployed via docker-compose

### Installing

#### non-docker

1. Start a web server with PHP support.
2. Confirm the PHP server has redis support, which cannot be simply installed in php.ini, but

```
# i.e. Ubuntu & Debian
apt install php8.4-redis

# i.e. Alpine
apk add --no-cache php84-pecl-redis
```

3. Start a Redis service
4. Copy the files in /webroot/ to any web folder.
5. In config.php, change the redis address (usually 127.0.0.1), and the admin password.

#### docker 

```
docker compose up -d
```
In config.php, change the admin password.

### Built with
- PHP
- BootStrap
- Jquery

### Acknowledgement

The Dockerfile environment is built based on TrafeX's Docker image.
https://github.com/TrafeX/docker-php-nginx