# Blog backend
[Lumen](https://lumen.laravel.com/) project providing an API to a blog environment, with Users, Posts and Comments.    
    
Documentation can be found [here](https://blog-aronnebrivio.restlet.io).

## Installation
- Install required dependencies with `composer install`    
- Create a local database accordingly to the `.env` file    
- Run the migrations with `php artisan migrate:refresh` (if you want some random data run with `--seed`)    
- Serve it locally creating a vhost that points to the project root    
    
## Test
Tests are under `/tests` folder, run it with `phpunit`.