<?php

/**
 * Routes Configuration
 * 
 * Middleware yang tersedia:
 * - auth: Cek apakah user sudah login
 * - guest: Cek apakah user belum login (untuk halaman login/register)
 * - role:admin: Cek apakah user memiliki role admin
 * - role:user: Cek apakah user memiliki role user
 * 
 * Note: PHP 5.2.9 tidak support closures, jadi tidak bisa menggunakan route grouping.
 * Routes didefinisikan secara manual dengan middleware di setiap route.
 */

// Guest routes (tidak perlu login) - Uncomment jika sudah ada AuthController
// $router->get('/login', 'AuthController@login', array('guest'));
// $router->post('/login', 'AuthController@login_process', array('guest'));
// $router->get('/register', 'AuthController@register', array('guest'));
// $router->post('/register', 'AuthController@register_process', array('guest'));

// Public routes (tanpa middleware)
$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->post('/', 'HomeController@add_data');
$router->post('/update/{id}', 'HomeController@update_data');
$router->post('/delete/{id}', 'HomeController@delete_data');

// Protected routes (perlu login) - Uncomment jika sudah implementasi auth
// $router->get('/', 'HomeController@index', array('auth'));
// $router->get('/home', 'HomeController@index', array('auth'));
// $router->post('/', 'HomeController@add_data', array('auth'));
// $router->post('/update/{id}', 'HomeController@update_data', array('auth'));
// $router->post('/delete/{id}', 'HomeController@delete_data', array('auth'));
// $router->get('/logout', 'AuthController@logout', array('auth'));

// Admin routes (perlu login + role admin) - Uncomment jika sudah ada controller
// $router->get('/admin/dashboard', 'HomeController@admin_dashboard', array('auth', 'role:admin'));
// $router->get('/admin/users', 'HomeController@admin_users', array('auth', 'role:admin'));
// $router->get('/admin/users/add', 'HomeController@admin_users_add', array('auth', 'role:admin'));
// $router->post('/admin/users/add', 'HomeController@admin_users_add_process', array('auth', 'role:admin'));
// $router->get('/admin/users/edit/{id}', 'HomeController@admin_users_edit', array('auth', 'role:admin'));
// $router->post('/admin/users/edit/{id}', 'HomeController@admin_users_edit_process', array('auth', 'role:admin'));
// $router->post('/admin/users/delete/{id}', 'HomeController@admin_users_delete', array('auth', 'role:admin'));
// $router->get('/admin/settings', 'HomeController@admin_settings', array('auth', 'role:admin'));
// $router->post('/admin/settings', 'HomeController@admin_settings_update', array('auth', 'role:admin'));
// $router->get('/admin/reports', 'HomeController@admin_reports', array('auth', 'role:admin'));
