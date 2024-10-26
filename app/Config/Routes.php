<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/profile', 'Profile::index');
$routes->get('/about', 'About::index');
// $routes->get('/product', 'Product::index');


$routes->get('/products', 'Products::index');
$routes->get('/products/create', 'Products::create');
$routes->post('/products/store', 'Products::store');
$routes->get('/products/edit/(:num)', 'Products::edit/$1');
$routes->post('/products/update/(:num)', 'Products::update/$1');
$routes->get('/products/delete/(:num)', 'Products::delete/$1');
