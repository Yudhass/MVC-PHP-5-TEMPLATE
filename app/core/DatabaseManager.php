<?php

/**
 * DatabaseManager
 * Mengelola multiple database connections
 * Compatible with PHP 5.2, 7, 8+
 */

class DatabaseManager
{
    private static $connections = array();
    private static $configs = array();
    
    /**
     * Register database configuration
     * 
     * @param string $name Connection name
     * @param array $config Database configuration
     */
    public static function addConnection($name, $config)
    {
        self::$configs[$name] = $config;
    }
    
    /**
     * Get database connection by name
     * 
     * @param string $name Connection name (default: 'default')
     * @return DatabaseConnection
     */
    public static function connection($name = 'default')
    {
        // Jika connection belum dibuat, buat baru
        if (!isset(self::$connections[$name])) {
            if (!isset(self::$configs[$name])) {
                die("Database configuration for '{$name}' not found.");
            }
            
            self::$connections[$name] = new DatabaseConnection(self::$configs[$name]);
        }
        
        return self::$connections[$name];
    }
    
    /**
     * Get default connection
     */
    public static function getDefaultConnection()
    {
        return self::connection('default');
    }
    
    /**
     * Close all connections
     */
    public static function closeAll()
    {
        foreach (self::$connections as $connection) {
            $connection->closeConnection();
        }
        self::$connections = array();
    }
    
    /**
     * Close specific connection
     */
    public static function close($name)
    {
        if (isset(self::$connections[$name])) {
            self::$connections[$name]->closeConnection();
            unset(self::$connections[$name]);
        }
    }
}

/**
 * DatabaseConnection
 * Handle individual database connection
 * Compatible with PHP 5.2, 7, 8+
 */
class DatabaseConnection
{
    protected $pdo;
    protected $conn;
    protected $usePDO = true;
    protected $config;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->connect();
    }
    
    private function connect()
    {
        $host = $this->config['host'];
        $user = $this->config['user'];
        $pass = $this->config['pass'];
        $db = $this->config['name'];
        $port = isset($this->config['port']) ? $this->config['port'] : 3306;
        
        // Cek apakah PDO tersedia (PHP 5.3+)
        if (class_exists('PDO')) {
            try {
                $this->usePDO = true;
                $options = array(
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                );

                $dsn = "mysql:host=$host;port=$port;dbname=$db";
                // Charset UTF8 hanya untuk PHP 5.3.6+
                if (version_compare(PHP_VERSION, '5.3.6', '>=')) {
                    $dsn .= ";charset=utf8";
                }
                
                $this->pdo = new PDO($dsn, $user, $pass, $options);
                
                // Set charset untuk versi dibawah 5.3.6
                if (version_compare(PHP_VERSION, '5.3.6', '<')) {
                    $this->pdo->exec("SET NAMES utf8");
                }
                
                return $this->pdo;
            } catch (PDOException $e) {
                die("PDO Connection failed: " . $e->getMessage());
            }
        } else {
            // Fallback ke mysql_* untuk PHP 5.2
            $this->usePDO = false;
            $this->conn = mysql_connect("$host:$port", $user, $pass);
            
            if (!$this->conn) {
                die("MySQL Connection failed: " . mysql_error());
            }
            
            $select_db = mysql_select_db($db, $this->conn);
            if (!$select_db) {
                die("Database selection failed: " . mysql_error());
            }
            
            // Set charset
            mysql_query("SET NAMES utf8", $this->conn);
            
            return $this->conn;
        }
    }
    
    public function query($query, $params = array())
    {
        if ($this->usePDO) {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } else {
            // Untuk PHP 5.2 tanpa PDO, gunakan mysql_* functions
            // Ganti placeholders dengan nilai sebenarnya
            foreach ($params as $key => $value) {
                $escapedValue = $this->escapeString($value);
                $query = str_replace(':' . $key, "'" . $escapedValue . "'", $query);
            }
            $result = mysql_query($query, $this->conn);
            return $result;
        }
    }
    
    public function prepare($sql)
    {
        if ($this->usePDO) {
            return $this->pdo->prepare($sql);
        } else {
            // Untuk PHP 5.2, return query langsung
            return $sql;
        }
    }
    
    public function fetch($stmt)
    {
        if ($this->usePDO) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return mysql_fetch_assoc($stmt);
        }
    }
    
    public function fetchAll($stmt)
    {
        if ($this->usePDO) {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            $data = array();
            while ($row = mysql_fetch_object($stmt)) {
                $data[] = $row;
            }
            return $data;
        }
    }
    
    public function fetchObject($stmt)
    {
        if ($this->usePDO) {
            return $stmt->fetch(PDO::FETCH_OBJ);
        } else {
            return mysql_fetch_object($stmt);
        }
    }
    
    public function escapeString($value)
    {
        if ($this->usePDO) {
            return substr($this->pdo->quote($value), 1, -1);
        } else {
            return mysql_real_escape_string($value, $this->conn);
        }
    }
    
    public function lastInsertId()
    {
        if ($this->usePDO) {
            return $this->pdo->lastInsertId();
        } else {
            return mysql_insert_id($this->conn);
        }
    }
    
    public function closeConnection()
    {
        if ($this->usePDO) {
            $this->pdo = null;
        } else {
            if ($this->conn) {
                mysql_close($this->conn);
            }
        }
    }
    
    public function isUsingPDO()
    {
        return $this->usePDO;
    }
    
    public function getPDO()
    {
        return $this->pdo;
    }
    
    public function getConn()
    {
        return $this->conn;
    }
}
