<?php
require_once dirname(__FILE__) . '/../models/User.php';

class HomeController extends Controller
{

    public function index()
    {
        $User = new User();

        // Contoh SELECT ALL - Ambil semua data
        $data = $User->selectAll(); // atau $User->all();

        // Using new template system with parameters
        return $this->template('home', array(
            'title' => 'Home - Dashboard',
            'layout' => 'layouts/master',
            'navbar' => true,
            'footer' => true,
            'sidebar' => false,
            'wrapperClass' => 'container',
            'brandName' => 'MVC Template System',
            'footerText' => 'MVC PHP 5 Template',
            'data_user' => $data,
            'css' => array(
                // Add custom CSS files here
                // BASEURL . 'css/custom.css'
            ),
            'js' => array(
                // Add custom JS files here
                // BASEURL . 'js/custom.js'
            ),
            'styles' => '
                /* Add inline styles here */
                .custom-header { padding: 20px; }
            ',
            'scripts' => '
                // Add inline scripts here
                console.log("Home page loaded");
            '
        ));
    }

    // INSERT - Tambah data baru
    public function add_data()
    {
        // CSRF Protection
        if (CSRF_ENABLED && !verify_csrf()) {
            $this->redirectBack('Invalid CSRF token. Please try again.', 'error');
            return;
        }

        // Rate Limiting
        if (RATE_LIMIT_ENABLED && !rate_limit('add_data', 10, 60)) {
            $this->redirectBack('Too many attempts. Please try again later.', 'error');
            return;
        }

        $User = new User();

        // Sanitize and validate input
        $nama = isset($_POST['nama']) ? sanitize($_POST['nama'], 'string') : null;

        if (empty($nama)) {
            $this->redirectBack('Name is required.', 'error');
            return;
        }

        // Validate name length
        if (!validate($nama, 'min', array('min' => 3)) || !validate($nama, 'max', array('max' => 100))) {
            $this->redirectBack('Name must be between 3 and 100 characters.', 'error');
            return;
        }

        // Contoh INSERT
        $data = $User->insert(array(
            'nama' => $nama
        ));

        if (!$data) {
            $this->redirectBack('Failed to add data. Please try again.', 'error');
        } else {
            $this->redirectBack('Success to add data');
        }
    }

    // UPDATE - Update data berdasarkan ID
    public function update_data($id)
    {
        // CSRF Protection
        if (CSRF_ENABLED && !verify_csrf()) {
            $this->redirectBack('Invalid CSRF token. Please try again.', 'error');
            return;
        }

        // Rate Limiting
        if (RATE_LIMIT_ENABLED && !rate_limit('update_data', 10, 60)) {
            $this->redirectBack('Too many attempts. Please try again later.', 'error');
            return;
        }

        // Sanitize ID
        $id = sanitize($id, 'int');

        $user = new User();

        // Contoh SELECT ONE - Cari data berdasarkan ID
        $data = $user->selectOne($id); // atau $user->find($id);

        if (!$data) {
            $this->redirectBack('Data tidak ditemukan', 'error');
        } else {
            // Sanitize and validate input
            // CSRF Protection
            if (CSRF_ENABLED && !verify_csrf()) {
                $this->redirectBack('Invalid CSRF token. Please try again.', 'error');
                return;
            }

            // Rate Limiting
            if (RATE_LIMIT_ENABLED && !rate_limit('delete_data', 5, 60)) {
                $this->redirectBack('Too many attempts. Please try again later.', 'error');
                return;
            }

            // Sanitize ID
            $id = sanitize($id, 'int');

            $nama = isset($_POST['nama']) ? sanitize($_POST['nama'], 'string') : '';

            if (empty($nama)) {
                $this->redirectBack('Name is required.', 'error');
                return;
            }

            if (!validate($nama, 'min', array('min' => 3)) || !validate($nama, 'max', array('max' => 100))) {
                $this->redirectBack('Name must be between 3 and 100 characters.', 'error');
                return;
            }

            // Contoh UPDATE BY ID
            $updated = $user->updateById($id, array(
                'nama' => $nama
            ));

            if ($updated) {
                $this->redirectBack('Data berhasil diperbarui', 'success');
            } else {
                $this->redirectBack('Tidak ada perubahan pada data', 'info');
            }
        }
    }

    // DELETE - Hapus data berdasarkan ID
    public function delete_data($id)
    {
        $user = new User();
        $data = $user->find($id);

        if (!$data) {
            $this->redirectBack('Data tidak ditemukan', 'error');
        } else {
            // Contoh DELETE BY ID
            $deleted = $user->deleteById($id); // atau $user->delete($id);

            if ($deleted) {
                $this->redirectBack('Data berhasil dihapus', 'success');
            } else {
                $this->redirectBack('Data gagal dihapus', 'info');
            }
        }
    }

    // Contoh SELECT WHERE - Cari data dengan kondisi
    public function search_by_name()
    {
        $user = new User();
        $nama = isset($_GET['nama']) ? $_GET['nama'] : '';

        // Contoh SELECT WHERE
        $data = $user->selectWhere('nama', '%' . $nama . '%', 'LIKE');

        // Atau menggunakan query builder:
        // $data = $user->where('nama', '%' . $nama . '%', 'LIKE')->get();

        return $this->view(
            'home',
            array(
                'title' => 'Search Results',
                'data_user' => $data
            )
        );
    }

    // Contoh mendapatkan satu data dengan WHERE
    public function get_user_detail($id)
    {
        $user = new User();

        // Cara 1: Menggunakan find
        $data = $user->find($id);

        // Cara 2: Menggunakan where dengan first
        // $data = $user->where('id', $id)->first();

        if ($data) {
            return $this->view(
                'user_detail',
                array(
                    'title' => 'User Detail',
                    'user' => $data
                )
            );
        } else {
            $this->redirectBack('Data tidak ditemukan', 'error');
        }
    }
}
