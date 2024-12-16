<?php 

class UserModel extends Model {
    // Definisikan nama tabel yang digunakan oleh model ini
    protected $table = 'users';  // Misal, tabel 'users'

    // Definisikan kolom yang bisa diisi
    protected $fillable = ['name', 'email', 'password'];
}
