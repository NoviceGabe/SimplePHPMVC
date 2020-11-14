<?php
chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';
require_once 'app/config/config.php';

use app\controller\Home;
use app\controller\User;

$app = new \app\lib\Application();

$app->router->get('','home');

$app->router->post('subscribe', [Home::class, 'subscribe']);

$app->router->get('login', [Home::class, 'login']);

$app->router->post('login', [Home::class, 'login']);

$app->router->post('index/subscribe', [Home::class, 'subscribe']);

$app->router->get('register', [Home::class, 'register']);

$app->router->post('register', [Home::class, 'register']);

$app->router->get('index/login', [Home::class, 'login']);

$app->router->post('index/login', [Home::class, 'login']);

$app->router->get('index/register', [Home::class, 'register']);

$app->router->post('index/register', [Home::class, 'register']);

$app->router->get('user', User::class);

$app->router->get('user/index', [User::class, 'index']);

$app->router->get('user/logout', [User::class, 'logout']);

$app->run();

