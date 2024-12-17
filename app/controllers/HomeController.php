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

        if (!$data) {
            $this->redirectBack('Failed to add data. Please try again.', 'error');
        } else {
            $this->redirectBack('Success to add data');
        }
    }

    public function update_data($id)
    {
        $user = new User();
        $data = $user->find($id);

        if (!$data) {
            $this->redirectBack('Data tidak ditemukan', 'error');
        } else {
            // Data yang akan di-update
            $updateData = array(
                'id' => $id,
                'nama' => $_POST['nama']
            );

            // Update data di database
            $updated = $user->update($updateData);

            if ($updated) {
                $this->redirectBack('Data berhasil diperbarui', 'success');
            } else {
                $this->redirectBack('Tidak ada perubahan pada data', 'info');
            }
        }
    }

    public function delete_data($id)
    {
        $user = new User();
        $data = $user->find($id);

        if (!$data) {
            $this->redirectBack('Data tidak ditemukan', 'error');
        } else {

            // delete data di database
            $deleted = $user->delete($id);

            if ($deleted) {
                $this->redirectBack('Data berhasil dihapus', 'success');
            } else {
                $this->redirectBack('Data gagal dihapus', 'info');
            }
        }
    }
}
