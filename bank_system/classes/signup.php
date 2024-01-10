<?php
class Signup {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database;
    }

    public function createUser($username, $email, $password) {
        if (empty($username) || empty($email) || empty($password)) {
            return "Please fill in all the fields.";
        }

        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $this->db->getConnection()->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            $userId = $this->db->getConnection()->lastInsertId();

            return "User registered successfully with ID: $userId";
        } catch (PDOException $e) {
            return "Error registering user: " . $e->getMessage();
        }
    }
}
?>