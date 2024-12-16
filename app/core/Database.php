<?php

class Database
{
    private static $instance = null;
    protected $pdo;
    private $conn;

    public function __construct()
    {
        $this->pdo = $this->setConnect();
    }

    public function query($query, $params = array())
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function setConnect()
    {
        try {
            $host = DB_HOST;
            $user = DB_USER;
            $pass = DB_PASS;
            $db = DB_NAME;
            $port = DB_PORT;

            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            );

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";
            $this->pdo = new PDO($dsn, $user, $pass, $options);
            return $this->pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function closeConnection()
    {
        $this->pdo = null;
    }
}
