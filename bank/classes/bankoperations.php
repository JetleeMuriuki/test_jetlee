<?php

class BankOperations
{
    private $db;

    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    public function getAccountBalance($accountNumber)
    {
        try {
            $stmt = $this->db->getConnection()->prepare("SELECT balance FROM accounts WHERE account_number = :account_number");
            $stmt->bindParam(':account_number', $accountNumber);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['balance'];
            } else {
                return "Account not found";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function addTransaction($accountNumber, $amount)
    {
        try {
            $this->db->getConnection()->beginTransaction();

            // Update the account balance
            $stmtUpdate = $this->db->getConnection()->prepare("UPDATE accounts SET balance = balance + :amount WHERE account_number = :account_number");
            $stmtUpdate->bindParam(':amount', $amount);
            $stmtUpdate->bindParam(':account_number', $accountNumber);
            $stmtUpdate->execute();

            // Insert transaction record
            $stmtInsert = $this->db->getConnection()->prepare("INSERT INTO transactions (account_number, amount) VALUES (:account_number, :amount)");
            $stmtInsert->bindParam(':amount', $amount);
            $stmtInsert->bindParam(':account_number', $accountNumber);
            $stmtInsert->execute();

            $this->db->getConnection()->commit();

            return "Transaction successful";
        } catch (PDOException $e) {
            $this->db->getConnection()->rollBack();
            return "Error: " . $e->getMessage();
        }
    }
}

?>