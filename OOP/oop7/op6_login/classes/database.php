<?php
class Database {
    private $host = 'localhost';
    private $username = 'username';
    private $password = 'password';
    private $database = 'database';

    private $conn;

    // Constructor
    public function __construct() {
        $this->connect();
    }

    // Destructor
    public function __destruct() {
        $this->disconnect();
    }

    // Connect to the database
    private function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Disconnect from the database
    private function disconnect() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    // Execute a query
    private function executeQuery($sql) {
        $result = $this->conn->query($sql);
        return $result;
    }}