<?php

class Controller
{


    public function view($view, $data = array())
    {
        if (!file_exists(dirname(__FILE__) . '/../views/' . $view . '.php')) {
            echo "File : " . dirname(__FILE__) . '/../views/' . $view . '.php Tidak ditemukan';
            die();
        }

        if (count($data)) {
            extract($data);
        }
        require_once dirname(__FILE__) . '/../views/' . $view . '.php';
    }
}
