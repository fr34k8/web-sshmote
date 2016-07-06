<?php
use App\Middlewares\AuthMiddleware;

$auth_middleware = new AuthMiddleware($app);

$app->get('/', 'App\\Controllers\\HomeController:index')->setName('web.home.index');
$app->post('/signin', 'App\\Controllers\\HomeController:signin')->setName('web.home.signin');
$app->get('/signout', 'App\\Controllers\\HomeController:signout')->setName('web.home.signout');

$app->group('/dashboard', function() {
    $this->get('/', 'App\\Controllers\\DashboardController:index')->setName('web.dashboard.index');
})->add($auth_middleware);

$app->group('/server', function() {
    $this->get('/create', 'App\\Controllers\\ServerController:create')->setName('web.server.create');
})->add($auth_middleware);
