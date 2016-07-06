<?php
use App\Middlewares\AuthMiddleware;

$auth_middleware = new AuthMiddleware($app);

$app->get('/', 'App\\Controllers\\HomeController:index')->setName('web.home.index');
$app->post('/signin', 'App\\Controllers\\HomeController:signin')->setName('web.home.signin');
$app->get('/signout', 'App\\Controllers\\HomeController:signout')->setName('web.home.signout');

$app->group('/dashboard', function() {
    $this->get('/', 'App\\Controllers\\DashboardController:index')->setName('web.dashboard.index');
    $this->post('/run', 'App\\Controllers\\DashboardController:run')->setName('web.dashboard.run');
    $this->get('/result', 'App\\Controllers\\DashboardController:result')->setName('web.dashboard.result');
});

$app->group('/server', function() {
    $this->get('/index', 'App\\Controllers\\ServerController:index')->setName('web.server.index');
    $this->get('/create', 'App\\Controllers\\ServerController:create')->setName('web.server.create');
    $this->post('/store', 'App\\Controllers\\ServerController:store')->setName('web.server.store');
    $this->get('/edit/{id}', 'App\\Controllers\\ServerController:edit')->setName('web.server.edit');
    $this->post('/update', 'App\\Controllers\\ServerController:update')->setName('web.server.update');
})->add($auth_middleware);
