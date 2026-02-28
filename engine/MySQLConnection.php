<?php
class MySQLConnection
{
    private $host = 'localhost';
    private $username = 'igorj';
    private $password = 'igorj';
    private $database = 'mape';
    private $conn;

    // Constructor to initialize connection parameters
    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        // Establish the connection
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            // Set PDO to throw exceptions on error
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    // Method to execute a query
    public function executeQuery($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Query execution failed: " . $e->getMessage());
        }
    }

    // Method to fetch a single row from a result set
    public function fetchSingle($query, $params = [])
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to fetch all rows from a result set
    public function fetchAll($query, $params = [])
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get the last inserted ID
    public function getLastInsertedId()
    {
        return $this->conn->lastInsertId();
    }

    // Destructor to close the connection when the object is destroyed
    public function __destruct()
    {
        $this->conn = null; // Close the connection
    }
}

// // Example usage:
// $host = 'localhost';
// $username = 'your_username';
// $password = 'your_password';
// $database = 'your_database';

// try {
//     $db = new MySQLConnection($host, $username, $password, $database);

//     // Example query execution:
//     $result = $db->fetchAll("SELECT * FROM users");
//     print_r($result);
// } catch (Exception $e) {
//     echo "Error: " . $e->getMessage();
// }
