<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages::home', ['as' => 'home']);
$routes->get('about', 'Pages::about', ['as' => 'about']);
$routes->get('work', 'Projects::index', ['as' => 'work']);
$routes->get('work/(:segment)', 'Projects::show/$1', ['as' => 'project.show']);
$routes->get('contact', 'Contact::index', ['as' => 'contact']);
$routes->post('contact', 'Contact::send', ['filter' => ['csrf', 'honeypot', 'throttle:5,60'], 'as' => 'contact.send']);
$routes->get('api/github', 'Api\GitHub::stats', ['as' => 'api.github']);
$routes->get('sitemap.xml', 'Pages::sitemap', ['as' => 'sitemap']);
$routes->set404Override('App\Controllers\Pages::notFound');
