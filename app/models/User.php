<?php 

require_once dirname(__FILE__) . '/../core/Model.php';

class User extends Model
{
    protected $table = 'tbl_user';
    protected $fields = array('id', 'nama');

    // Contoh penggunaan method-method CRUD:
    
    // 1. INSERT - Tambah data baru
    // $user = new User();
    // $result = $user->insert(array('nama' => 'John Doe'));
    
    // 2. SELECT ALL - Ambil semua data
    // $user = new User();
    // $allUsers = $user->selectAll(); // atau $user->all();
    
    // 3. SELECT ONE - Ambil satu data berdasarkan ID
    // $user = new User();
    // $oneUser = $user->selectOne(1); // atau $user->find(1);
    
    // 4. SELECT WHERE - Ambil data dengan kondisi
    // $user = new User();
    // $users = $user->selectWhere('nama', 'John', 'LIKE');
    // atau gunakan query builder:
    // $users = $user->where('nama', 'John')->get();
    
    // 5. UPDATE - Update data (memerlukan id dalam array)
    // $user = new User();
    // $updated = $user->update(array('id' => 1, 'nama' => 'Jane Doe'));
    
    // 6. UPDATE BY ID - Update berdasarkan ID
    // $user = new User();
    // $updated = $user->updateById(1, array('nama' => 'Jane Doe'));
    
    // 7. DELETE - Hapus data berdasarkan ID
    // $user = new User();
    // $deleted = $user->delete(1);
    
    // 8. DELETE BY ID - Sama dengan delete
    // $user = new User();
    // $deleted = $user->deleteById(1);
}