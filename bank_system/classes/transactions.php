<?php

class Transaction {
    private $db;
    private $account;
    private $amount;
    private $type;
    private $timestamp;

    public function __construct(Database $database, $account, $amount, $type) {
        $this->db = $database;
        $this->account = $account;
        $this->amount = $amount;
        $this->type = $type; // 'withdrawal' or 'deposit'
        $this->timestamp = date('Y-m-d H:i:s'); // Store the current timestamp
    }

    public function saveTransaction() {
        try {
            $stmt = $this->db->getConnection()->prepare("INSERT INTO transactions (account, amount, type, timestamp) VALUES (:account, :amount, :type, :timestamp)");
            $stmt->bindParam(':account', $this->account);
            $stmt->bindParam(':amount', $this->amount);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':timestamp', $this->timestamp);
            $stmt->execute();
            return true; // Transaction saved successfully
        } catch (PDOException $e) {
            return false; // Error saving transaction
        }
    }

    public function performTransaction() {
        try {
            $this->db->getConnection()->beginTransaction();

            // Implement the logic for the transaction (withdrawal or deposit)
            // For a simple example, let's just print the transaction details and save to the database
            echo "Transaction details:\n";
            echo "Account: {$this->account}\n";
            echo "Type: {$this->type}\n";
            echo "Amount: {$this->amount}\n";
            echo "Timestamp: {$this->timestamp}\n";

            // Save the transaction to the database
            if ($this->saveTransaction()) {
                echo "Transaction saved to the database.\n";
            } else {
                throw new Exception("Error saving transaction to the database.");
            }

            $this->db->getConnection()->commit();
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            echo "Transaction failed: " . $e->getMessage() . "\n";
        }
    }
}
