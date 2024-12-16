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

    public function dd($data)
    {
        var_dump($data);
        die();
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

    // Custom redirect method
    public function redirect($route, $message = null, $type = 'success')
    {
        // Store the message in session to display it on the next page
        if ($message) {
            $_SESSION['flash_message'] = $message;
            $_SESSION['flash_message_type'] = $type; // success, error, etc.
        }

        // Redirect to the specified route
        header('Location: ' . $route);
        exit;
    }

    // Redirect back to the previous page
    public function redirectBack($message = null, $type = 'success')
    {
        if ($message) {
            $_SESSION['flash_message'] = $message;
            $_SESSION['flash_message_type'] = $type;
        }

        // Redirect back to the previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }   
}
