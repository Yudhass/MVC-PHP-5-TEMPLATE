<?php
require_once dirname(__FILE__) . '/../models/User.php';

class HomeController extends Controller
{
    public function index()
    {
        $data = new User();
        $data = $data->all();

        return $this->view(
            'home',
            array(
                'title' => 'Home',
                'data_user' => $data
            )
        );
    }

    public function about()
    {
        echo "This is the About Page.";
    }
}
