<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');


$routes->get('/', 'Comments::index');
$routes->get('comments', 'Comments::index');

// API-маршруты для работы с комментариями
$routes->group('api', function ($routes) {
    $routes->post('comments/add', 'Comments::addComment');
    $routes->delete('comments/delete/(:num)', 'Comments::deleteComment/$1');
});