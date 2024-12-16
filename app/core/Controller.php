<?php

class Controller
{


    public function view($view, $data = array())
    {
        if (!file_exists(__DIR__ . '/../views/' . $view . '.php')) {
            echo "File : " . __DIR__ . '/../views/' . $view . '.php Tidak ditemukan';
            die();
        }

        if (count($data)) {
            extract($data);
        }
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}
