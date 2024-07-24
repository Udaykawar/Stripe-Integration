<?php

class Database
{
    public $conn;

    public function __construct()
    {
        // Load configuration
        $config = require __DIR__ . '/../config/config.php';

        // Create a new database connection
        $this->conn = new mysqli(
            $config['database']['host'],
            $config['database']['user'],
            $config['database']['password']
        );

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Create the database if it does not exist
        $this->conn->query("CREATE DATABASE IF NOT EXISTS " .  $config['database']['name']);
        $this->conn->select_db($config['database']['name']);
    }

    // Method to get the connection
    public function getConnection()
    {
        return $this->conn;
    }
}
?>
