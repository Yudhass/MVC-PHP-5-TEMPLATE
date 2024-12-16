<?php

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home',['title' => 'Home']);
    }

    public function about()
    {
        echo "This is the About Page.";
    }
}
