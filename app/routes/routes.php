<?php
return array(
    array('GET', '/', 'HomeController@index'),
    array('GET', '/about', 'HomeController@about'),
    array('GET', '/product/{id}', 'ProductController@show'),
    array('POST', '/product', 'ProductController@store'),
    array('PUT', '/product/{id}', 'ProductController@update'),
    array('DELETE', '/product/{id}', 'ProductController@destroy'),
);
?>