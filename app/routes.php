<?php
$app->get('/', 'App\\Controllers\\HomeController:index')->setName('web.home.index');
$app->post('/signin', 'App\\Controllers\\HomeController:signin')->setName('web.home.signin');
