<?php

class Database
{
    private static $instance = null;
    private $conn;

    public function __construct()
    {
        // Inisialisasi koneksi
        $this->conn = $this->setConnect();
    }

    /**
     * Eksekusi query dengan parameter
     * 
     * @param string $query SQL Query
     * @param array $params Array parameter untuk query
     * @return PDOStatement
     */
    public function query($query, $params = array())
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    public static function getInstance()
    {
        // Jika instance belum ada, buat dan simpan
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Koneksi ke database menggunakan PDO
     * 
     * @return PDO Koneksi database
     */
    private function setConnect()
    {
        try {
            $host = DB_HOST;
            $user = DB_USER;
            $pass = DB_PASS;
            $db = DB_NAME;
            $port = DB_PORT;

            // Opsi koneksi PDO
            $options = array(
                PDO::ATTR_PERSISTENT => true,   // Menggunakan koneksi persisten
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Menangani error dengan exceptions
            );

            // Membuat koneksi ke database
            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";
            $this->conn = new PDO($dsn, $user, $pass, $options);
            return $this->conn;
        } catch (PDOException $e) {
            // Jika terjadi error, tampilkan pesan error dan hentikan eksekusi
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Menutup koneksi database
     */
    public function closeConnection()
    {
        $this->conn = null;
    }
}
