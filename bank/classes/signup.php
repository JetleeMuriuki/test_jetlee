<?php

class Signup
{
    private $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    public function createUser($username, $email, $password) {
        if (empty($username) || empty($email) || empty($password)) {
            return "Please fill in all the fields.";
        }

        // Check if the email is already registered
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Email is already registered. Please use a different email.";
        }

        // Generate a unique user ID
        $userId = uniqid();

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new customers into the database
        $stmt = $this->db->prepare("INSERT INTO customers (customer_id, username, email, password) VALUES (:customer_id, :username, :email, :password)");
        $stmt->bindParam(':customer_id', $userId);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        return "User registered successfully with ID: $userId";
    }
}
?>