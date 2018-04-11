<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

$router->get('/', ExampleController::class . '@test');

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
    $router->post('/', ExampleController::class . '@testAuth');

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
        $router->put('/', UserController::class . '@edit');
    });
});
