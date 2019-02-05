 <?php

$router->get('', 'PagesController@home');
$router->get('about', 'PagesController@about');
$router->get('contact', 'PagesController@contact');

$router->get('users', 'UsersController@index');
$router->get('users/about', 'UsersController@test');
$router->get('users/:id', 'UsersController@show');
// echo "Routes";die;
$router->post('users', 'UsersController@store');
$router->post('users/delete', 'UsersController@delete');
