<?php

class HomeController extends Controller
{
    public function index()
    {
        return $this->view(
            'home',
            array('title' => 'Home')
        );
    }

    public function about()
    {
        echo "This is the About Page.";
    }
}
