<?php

return array(
    array('GET', '/', 'HomeController@index'),
    array('POST', '/', 'HomeController@add_data'),
    array('POST', '/update/{id}', 'HomeController@update_data'),
    array('POST', '/delete/{id}', 'HomeController@delete_data'),
);

?>