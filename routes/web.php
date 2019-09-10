<?php

use Laravel\Lumen\Routing\Router;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

/** @var Router $router */
$router->get('/', function () {
    return redirect('https://documenter.getpostman.com/view/4711074/SVmr11U3?version=latest');
});
$router->get('/version', function () {
    return response('0.9.1', 200);
});
$router->post('/auth', UserController::class . '@getToken');

$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', UserController::class . '@getAll');
    $router->post('/', UserController::class . '@new');
    $router->get('/{id}', UserController::class . '@get');
});

$router->group(['prefix' => 'posts'], function () use ($router) {
    $router->get('/', PostController::class . '@getAll');
    $router->get('/{id}', PostController::class . '@get');
});

$router->group(['prefix' => 'comments'], function () use ($router) {
    $router->get('/', CommentController::class . '@getAll');
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'posts'], function () use ($router) {
        $router->put('/{id}', PostController::class . '@update');
        $router->delete('/{id}', PostController::class . '@delete');
        $router->post('/', PostController::class . '@new');
    });

    $router->group(['prefix' => 'comments'], function () use ($router) {
        $router->put('/{id}', CommentController::class . '@update');
        $router->delete('/{id}', CommentController::class . '@delete');
        $router->post('/', CommentController::class . '@new');
    });

    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->put('/', UserController::class . '@update');
    });
});
