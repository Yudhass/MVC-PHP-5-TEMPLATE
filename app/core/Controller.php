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

    public function model($model)
    {
        $file = '../app/models/' . $model . '.php';

        // Cek apakah file model ada
        if (!file_exists($file)) {
            echo "File : " . $file . " Tidak ditemukan";
            die();
        }

        // Memasukkan file model
        require_once $file;

        // Pastikan kelas model ada, kemudian buat instance objeknya
        if (class_exists($model)) {
            return new $model();
        } else {
            echo "Kelas model : " . $model . " tidak ditemukan.";
            die();
        }
    }
}
