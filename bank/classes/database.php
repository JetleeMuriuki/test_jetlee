<?php

class Database
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $conn;

    public function __construct($host, $username, $password, $database){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
    }
    private function connect() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
}       
    public function query($sql, $params = []) {
    try {
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        return $statement;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
    public function fetchAll($sql, $params = []) {
    $statement = $this->query($sql, $params);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

    public function fetchRow($sql, $params = []) {
    $statement = $this->query($sql, $params);
    return $statement->fetch(PDO::FETCH_ASSOC);
}
     public function close() {
    $this->connection = null;
    }
}

?>
