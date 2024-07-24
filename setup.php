<?php

require_once __DIR__ . '/helpers/Database.php';

// Load configuration
$config = require __DIR__ . '/config/config.php';

// Create a Database object
$db = new Database();

// Database name from configuration
$dbName = $config['database']['name'];

// Create database if it does not exist
$createDatabaseSQL = "CREATE DATABASE IF NOT EXISTS $dbName";

// Create the database
if ($db->conn->query($createDatabaseSQL) === TRUE) {
    //echo "Database '$dbName' created successfully.<br>";
} else {
    echo "Error creating database: " . $db->conn->error . "<br>";
}

// Select the database
$db->conn->select_db($dbName);

// SQL to create a table for storing payments
$createTableSQL = "
    CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    amount INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    payment_intent_id VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Create the table
if ($db->conn->query($createTableSQL) === TRUE) {
    // echo "Table 'payments' created successfully.";
} else {
    echo "Error creating table: " . $db->conn->error;
}
?>
