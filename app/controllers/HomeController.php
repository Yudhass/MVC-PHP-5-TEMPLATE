<?php

class HomeController
{
    public function index()
    {
        require_once __DIR__ . '/../views/home.php';
    }

    public function about()
    {
        echo "This is the About Page.";
    }
}
