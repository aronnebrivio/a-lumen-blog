<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

$router->get('/', ExampleController::class . '@test');

$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', UserController::class . '@getAll');
    $router->get('/{id}', UserController::class . '@get');
});

$router->group(['prefix' => 'posts'], function () use ($router) {
    $router->get('/', PostController::class . '@getAll');
    $router->get('/{id}', PostController::class . '@get');
    $router->post('/', PostController::class . '@new');
});

$router->group(['prefix' => 'comments'], function () use ($router) {
    $router->get('/', CommentController::class . '@getAll');
    $router->post('/', CommentController::class . '@new');
});
