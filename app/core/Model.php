<?php

class Model extends Database
{

    // Database connection instance
    protected $db;
    protected $table;
    protected $fillable = [];

    // Constructor untuk memulai koneksi database
    public function __construct()
    {
        // Pastikan sudah ada koneksi database
        $this->db = Database::getInstance();  // Asumsi ada kelas Database untuk mengelola koneksi
    }

    // Menyimpan data ke dalam tabel
    public function save($data)
    {
        // Filter data hanya yang ada di $fillable
        $data = array_intersect_key($data, array_flip($this->fillable));

        // Siapkan query untuk insert
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);

        // Bind values ke query
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    // Mengambil semua data
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil data berdasarkan kondisi tertentu
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mengupdate data berdasarkan id
    public function update($id, $data)
    {
        $data = array_intersect_key($data, array_flip($this->fillable)); // Filter data

        $set = '';
        foreach ($data as $column => $value) {
            $set .= "$column = :$column, ";
        }
        $set = rtrim($set, ', ');

        $sql = "UPDATE {$this->table} SET $set WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Bind values
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    // Menghapus data berdasarkan id
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    // Getter untuk nama tabel
    public function getTable()
    {
        return $this->table;
    }
}
