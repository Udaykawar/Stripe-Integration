<?php

class Database
{
    public $conn;

    public function __construct()
    {
        // Configuration settings
        $config = [
            'host' => 'localhost',
            'user' => 'root',
            'password' => 'root', // Add your password here
            'name' => 'stripe_integration'
        ];

        // Create a new database connection
        $this->conn = new mysqli(
            $config['host'],
            $config['user'],
            $config['password']
        );

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Create the database if it does not exist
        $this->conn->query("CREATE DATABASE IF NOT EXISTS " . $config['name']);
        $this->conn->select_db($config['name']);
    }

    // Method to get the connection
    public function getConnection()
    {
        return $this->conn;
    }
}
?>
