<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/home/login', 'Home::login');
$routes->get('/products', 'Products::index');
$routes->get('/products/productEdit/(:num)', 'Products::productEdit/$1');
$routes->get('/products/productCreate', 'Products::productCreate');
// $routes->get('/products/productsList', 'Products::productsList');
// $routes->get('/products/productsPage/(:num)/(:num)', 'Products::productsPaginatedList/$1/$2');
$routes->post('/products/productsSearchPage', 'Products::productsSearchPaginatedList');
$routes->post('/products/createNew', 'Products::createNew');
$routes->post('/products/productUpdate/', 'Products::productUpdate');
$routes->delete('/products/productDelete/(:num)', 'Products::productDelete/$1');
