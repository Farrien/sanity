<?php

global $router;

$router->route('documents/pdf/(id:num)', 'vc?documents');

$router->route('account', 'controller?account/index');
$router->route('profile/(id)', 'controller?profile/user');
$router->route('profile/(id)', 'vc?profile/user');
$router->route('profile/(id)/photos', 'controller?profile/photos', 'GET');
