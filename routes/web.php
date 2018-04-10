<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', ExampleController::class . '@test');

/* get */
$router->get('/users', UserController::class . '@getAll');
$router->get('/user/{id}', UserController::class . '@get');

$router->get('/posts', PostController::class . '@getAll');
$router->get('/post/{id}', PostController::class . '@get');

$router->get('/comments', CommentController::class . '@getAll');
$router->get('/comment/{id}', CommentController::class . '@get');

/* new post-comment */
$router->post('/post/new', PostController::class . '@new');
$router->post('/comment/new', CommentController::class . '@new');