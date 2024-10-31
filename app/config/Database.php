<?php

class Database {
    private $connection;

    public function __construct() {
        // Load .env file
        $this->loadEnv(__DIR__ . '/../../.env');  // Move up two directories to reach the root

        // Retrieve database credentials from environment variables
        $host = $_ENV['DB_HOST'];
        $dbName = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        // Establish connection
        $this->connection = new mysqli($host, $user, $pass, $dbName);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    private function loadEnv($path) {
        if (!file_exists($path)) {
            throw new Exception(".env file not found!");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            list($name, $value) = explode('=', $line, 2);
            $_ENV[trim($name)] = trim($value);
        }
    }
}
