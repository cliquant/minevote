<?php

class Database {
    protected $db;

    public function __construct($database, $username = NULL,$password = NULL, $host = '127.0.0.1', $port = 3306,$options = []){

        $default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        
        $options = array_replace($default_options, $options);
        $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";

        try {
            $this->db = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function run($sql, $args = NULL) {
        if (!$args) {
            return $this->db->query($sql);
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}

