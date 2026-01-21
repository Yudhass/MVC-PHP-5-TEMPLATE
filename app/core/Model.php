<?php
require_once 'Database.php';

class Model extends Database
{
    protected $table;
    protected $fields = array();
    protected $query;
    protected $bindings = array();

    public function __construct()
    {
        parent::__construct();
    }

    // INSERT - Tambah data baru
    public function insert($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        if ($this->usePDO) {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return $this->find($this->pdo->lastInsertId());
        } else {
            // Untuk PHP 5.2
            foreach ($data as $key => $value) {
                $escapedValue = $this->escapeString($value);
                $sql = str_replace(':' . $key, "'" . $escapedValue . "'", $sql);
            }
            $result = mysql_query($sql, $this->conn);
            if ($result) {
                return $this->find(mysql_insert_id($this->conn));
            }
            return false;
        }
    }

    // Alias untuk insert (untuk backward compatibility)
    public function create($data)
    {
        return $this->insert($data);
    }

    // SELECT ALL - Ambil semua data
    public function selectAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        
        if ($this->usePDO) {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            // Untuk PHP 5.2
            $result = mysql_query($sql, $this->conn);
            $data = array();
            while ($row = mysql_fetch_object($result)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    // Alias untuk selectAll (untuk backward compatibility)
    public function all()
    {
        return $this->selectAll();
    }

    // SELECT ONE - Ambil satu data berdasarkan ID
    public function selectOne($id)
    {
        return $this->find($id);
    }

    // SELECT WHERE - Ambil data dengan kondisi where
    public function selectWhere($column, $value, $operator = '=')
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} :value";
        
        if ($this->usePDO) {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array(':value' => $value));
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            // Untuk PHP 5.2
            $escapedValue = $this->escapeString($value);
            $sql = str_replace(':value', "'" . $escapedValue . "'", $sql);
            $result = mysql_query($sql, $this->conn);
            $data = array();
            while ($row = mysql_fetch_object($result)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    // WHERE clause builder
    public function where($column, $value, $operator = '=')
    {
        if (empty($this->query)) {
            $this->query = "SELECT * FROM {$this->table} WHERE {$column} {$operator} :{$column}";
        } else {
            $this->query .= " AND {$column} {$operator} :{$column}";
        }
        $this->bindings[$column] = $value;
        return $this;
    }

    // Execute get - Ambil multiple results
    public function get()
    {
        if ($this->usePDO) {
            $stmt = $this->pdo->prepare($this->query);
            $stmt->execute($this->bindings);
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            // Untuk PHP 5.2
            $sql = $this->query;
            foreach ($this->bindings as $key => $value) {
                $escapedValue = $this->escapeString($value);
                $sql = str_replace(':' . $key, "'" . $escapedValue . "'", $sql);
            }
            $result = mysql_query($sql, $this->conn);
            $data = array();
            while ($row = mysql_fetch_object($result)) {
                $data[] = $row;
            }
            $result = $data;
        }
        
        // Reset query builder
        $this->query = '';
        $this->bindings = array();
        
        return $result;
    }

    // Execute first - Ambil satu result pertama
    public function first()
    {
        $this->query .= " LIMIT 1";
        
        if ($this->usePDO) {
            $stmt = $this->pdo->prepare($this->query);
            $stmt->execute($this->bindings);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
        } else {
            // Untuk PHP 5.2
            $sql = $this->query;
            foreach ($this->bindings as $key => $value) {
                $escapedValue = $this->escapeString($value);
                $sql = str_replace(':' . $key, "'" . $escapedValue . "'", $sql);
            }
            $result = mysql_query($sql, $this->conn);
            $result = mysql_fetch_object($result);
        }
        
        // Reset query builder
        $this->query = '';
        $this->bindings = array();
        
        return $result;
    }

    // UPDATE - Update data (memerlukan id di dalam array $data)
    public function update($data)
    {
        $setClause = '';
        foreach (array_keys($data) as $key) {
            if ($key !== 'id') {
                $setClause .= "{$key} = :{$key}, ";
            }
        }
        $setClause = rtrim($setClause, ', ');

        $sql = "UPDATE {$this->table} SET {$setClause} WHERE id = :id";

        // Pastikan 'id' selalu ada di array $data
        if (!isset($data['id'])) {
            throw new Exception("ID is required for updating records.");
        }

        if ($this->usePDO) {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return $stmt->rowCount();
        } else {
            // Untuk PHP 5.2
            foreach ($data as $key => $value) {
                $escapedValue = $this->escapeString($value);
                $sql = str_replace(':' . $key, "'" . $escapedValue . "'", $sql);
            }
            $result = mysql_query($sql, $this->conn);
            return mysql_affected_rows($this->conn);
        }
    }

    // UPDATE BY ID - Update data berdasarkan ID
    public function updateById($id, $data)
    {
        $data['id'] = $id;
        return $this->update($data);
    }

    // DELETE - Hapus data berdasarkan ID
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";

        if ($this->usePDO) {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array(':id' => $id));
            return $stmt->rowCount();
        } else {
            // Untuk PHP 5.2
            $escapedId = $this->escapeString($id);
            $sql = str_replace(':id', "'" . $escapedId . "'", $sql);
            $result = mysql_query($sql, $this->conn);
            return mysql_affected_rows($this->conn);
        }
    }

    // DELETE BY ID - Alias untuk delete
    public function deleteById($id)
    {
        return $this->delete($id);
    }

    // FIND - Cari data berdasarkan ID
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        
        if ($this->usePDO) {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array('id' => $id));
            return $stmt->fetch(PDO::FETCH_OBJ);
        } else {
            // Untuk PHP 5.2
            $escapedId = $this->escapeString($id);
            $sql = str_replace(':id', "'" . $escapedId . "'", $sql);
            $result = mysql_query($sql, $this->conn);
            return mysql_fetch_object($result);
        }
    }
}

