<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->resource('post');
$routes->put('post/(:num)' , 'post::update/$1');
$routes->get('/', 'Artikel::index');
$routes->get('home', 'Home::index');
$routes->get('artikel', 'Artikel::index');
$routes->get('artikel/detail/(:segment)', 'Artikel::detail/$1');
$routes->get('artikel/(:any)', 'Artikel::view/$1');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
$routes->get('ajax/index', 'AjaxControllers::index');
$routes->get('ajax/getData', 'Artikel::getData');
$routes->delete('ajax/delete/(:num)', 'Artikel::delete/$1');

$routes->group('admin', function ($routes) {
  $routes->get('artikel', 'Artikel::admin_index');
  $routes->get('artikel/add', 'Artikel::add');
  $routes->post('artikel/add', 'Artikel::add');
  $routes->get('artikel/detail/(:segment)', 'Artikel::admin_detail/$1');
  $routes->get('artikel/edit/(:any)', 'Artikel::edit/$1');
  $routes->post('artikel/edit/(:any)', 'Artikel::edit/$1');  
  $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

$routes->group('user', function ($routes) {
  $routes->get('login', 'User::login');
  $routes->post('login', 'User::login');
});
