# Blog backend
[Lumen](https://lumen.laravel.com/) project providing an API to a blog environment, with Users, Posts and Comments.

Documentation can be found [here](https://blog-aronnebrivio.restlet.io).

## Installation
- `cd` in project directory
- Install required dependencies with `composer install`
- Create `.env` file with `cd .env.example .env` and fill all variables
- Install [Docker](https://www.docker.com/) and run `docker-compose up -d` command
- Run migrations with `docker exec -it blog-lumen bash -c "php artisan migrate:fresh --seed"`
- Profit

## Test
Tests are under `/tests` folder, run it with `phpunit`.

**Note**: APIs will be available at `http://localhost:PHP_HOST_PORT`, where `PHP_HOST_PORT` is declared in `.env` file.
