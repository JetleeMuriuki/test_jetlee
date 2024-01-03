<?php

class Login
{
    private $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    public function authenticateUser($username, $password)
    {
        try {
            $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return true; // Authentication successful
            } else {
                return false; // Authentication failed
            }
        } catch (PDOException $e) {
            return false; // Error occurred during authentication
        }
    }
}
