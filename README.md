# Blog backend
[![CI/CD](https://github.com/aronnebrivio/a-lumen-blog/actions/workflows/ci-cd.yml/badge.svg)](https://github.com/aronnebrivio/a-lumen-blog/actions/workflows/ci-cd.yml)
[![Coverage Status](https://coveralls.io/repos/github/aronnebrivio/a-lumen-blog/badge.svg?branch=master)](https://coveralls.io/github/aronnebrivio/a-lumen-blog?branch=master)
[![LICENSE](https://img.shields.io/badge/license-MIT-gold.svg)](https://github.com/aronnebrivio/aronnebrivio.github.io/blob/master/LICENSE)

[Lumen](https://lumen.laravel.com/) project providing an API to a blog environment, with Users, Posts and Comments.

Documentation can be found [here](https://documenter.getpostman.com/view/4711074/SVmr11U3?version=latest).

## Requirements
- [Docker](https://www.docker.com/)

## Installation
- `cd` in project directory
- Create `.env` file with `cp .env.example .env` and fill all missing variables
- Start Lumen and Database containers with `docker-compose up -d`
- Install required dependencies with `docker exec -it blog-lumen bash -c "composer install"`
- Run migrations with `docker exec -it blog-lumen bash -c "php artisan migrate:fresh --seed"`
- Profit

### Notes
APIs will be available at `http://localhost:PHP_HOST_PORT`, where `PHP_HOST_PORT` is declared in `.env` file.   
You can enable or disable XDebug using the `XDEBUG_MODE` environment variable.  

## Test
Tests are under `/tests` folder, run it with `phpunit`.

## ToDo
- [x] Upgrade to Lumen 8.x
- [x] Upgrade to Composer 3
- [x] Automated PHP-CS-Fixer
- [x] Redis cache
- [x] Clean up local Docker environment
- [X] Review CI Docker environment
- [X] Use Github workflow
- [X] Setup a simple production environment  
- [X] Containerized infrastructure for server
- [ ] Makefile
- [ ] Pagination

## License
Copyright (c) 2020 Aronne Brivio. Released under the MIT License. See [LICENSE](https://github.com/aronnebrivio/a-lumen-blog/blob/master/LICENSE) for details.
