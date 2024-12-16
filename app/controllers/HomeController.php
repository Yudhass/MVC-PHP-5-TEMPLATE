<?php
require_once dirname(__FILE__) . '/../models/User.php';

class HomeController extends Controller
{

    public function index()
    {
        $User = new User();
        $data = $User->all();

        return $this->view(
            'home',
            array(
                'title' => 'Home',
                'data_user' => $data
            )
        );
    }

    public function add_data()
    {
        $User = new User();

        $nama = isset($_POST['nama']) ? $_POST['nama'] : null;
        $data = $User->create(array(
            'nama' => $nama
        ));
        
        if(!$data){
            $this->redirectBack('Failed to add data. Please try again.', 'error');
        }else{
            $this->redirectBack('Success to add data');
        }
    }
}
