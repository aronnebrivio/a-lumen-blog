# Blog backend
[Lumen](https://lumen.laravel.com/) project providing an API to a blog environment, with Users, Posts and Comments.

Production endpoint: [blog-backend.aronnebrivio.xyz](http://blog-backend.aronnebrivio.xyz)

Documentation can be found [here](https://documenter.getpostman.com/view/4711074/SVmr11U3?version=latest).

## Requirements
- [Docker](https://www.docker.com/)

## Installation
- `cd` in project directory
- Create `.env` file with `cd .env.example .env` and fill all variables
- Start Lumen and Database containers with `docker-compose up -d`
- Install required dependencies with `docker exec -it blog-lumen bash -c "composer install"`
- Run migrations with `docker exec -it blog-lumen bash -c "php artisan migrate:fresh --seed"`
- Profit

**Note**: APIs will be available at `http://localhost:PHP_HOST_PORT`, where `PHP_HOST_PORT` is declared in `.env` file.

## Test
Tests are under `/tests` folder, run it with `phpunit`.

## ToDo
- Makefile
- Dockerized deploy
