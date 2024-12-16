<?php
return [
    ['GET', '/', 'HomeController@index'],
    ['GET', '/about', 'HomeController@about'],
    ['GET', '/product/{id}', 'ProductController@show'],
    ['POST', '/product', 'ProductController@store'],
    ['PUT', '/product/{id}', 'ProductController@update'],
    ['DELETE', '/product/{id}', 'ProductController@destroy'],
];
?>