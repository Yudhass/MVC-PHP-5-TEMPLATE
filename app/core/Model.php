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

    // Create
    public function create(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return $this->find($this->pdo->lastInsertId());
    }

    // Read: Get all
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Read: Where clause
    public function where($column, $value, $operator = '=')
    {
        $this->query = $this->query ? $this->query . " AND {$column} {$operator} :{$column}" : "SELECT * FROM {$this->table} WHERE {$column} {$operator} :{$column}";
        $this->bindings[$column] = $value;
        return $this;
    }

    // Execute get
    public function get()
    {
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Execute first
    public function first()
    {
        $this->query .= " LIMIT 1";
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->bindings);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Update
    public function update(array $data)
    {
        $setClause = '';
        foreach (array_keys($data) as $key) {
            $setClause .= "{$key} = :{$key}, ";
        }
        $setClause = rtrim($setClause, ', ');

        $sql = "UPDATE {$this->table} SET {$setClause} WHERE " . str_replace('SELECT * FROM ' . $this->table . ' WHERE ', '', $this->query);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge($this->bindings, $data));
        return $stmt->rowCount();
    }

    // Delete
    public function delete()
    {
        $sql = "DELETE FROM {$this->table} WHERE " . str_replace('SELECT * FROM ' . $this->table . ' WHERE ', '', $this->query);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->rowCount();
    }

    // Find by primary key
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array('id' => $id));
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
