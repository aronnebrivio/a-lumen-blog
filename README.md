# Blog backend
> I'm currently porting this project from Gitlab. I used to automate the deploy with Gitlab CI using [Envoy](https://laravel.com/docs/8.x/envoy). I'll try to use the same approach with Github workflows and, once it will be up and running on a production endpoint, I'll try out new deploy technologies.

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
- [ ] Review CI Docker environment
- [ ] Use Github workflow
- [ ] Setup a simple production environment  
- [ ] Makefile
- [ ] Containerized infrastructure for server

## License
Copyright (c) 2020 Aronne Brivio. Released under the MIT License. See [LICENSE](https://github.com/aronnebrivio/a-lumen-blog/blob/master/LICENSE) for details.
