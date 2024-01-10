<?php
require_once('../classes/database.php');
require_once('../classes/transactions.php');


$db = Database::getInstance();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $amount = $_POST["amount"];
    $transaction_type = $_POST["transaction_type"]; // 'deposit' or 'withdrawal'

    try {
        $db->getConnection()->beginTransaction();

        // Insert data into the corresponding table based on the transaction type
        if ($transaction_type == 'deposit') {
            $stmt = $db->getConnection()->prepare("INSERT INTO deposits (user_id, amount) VALUES (:user_id, :amount)");
        } elseif ($transaction_type == 'withdrawal') {
            $stmt = $db->getConnection()->prepare("INSERT INTO withdrawals (user_id, amount) VALUES (:user_id, :amount)");
        } else {
            throw new Exception("Invalid transaction type");
        }

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':amount', $amount);
        $stmt->execute();

        $db->getConnection()->commit();

        echo "Transaction successfully recorded.";
    } catch (PDOException $e) {
        $db->getConnection()->rollBack();
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Form</title>
</head>
<body>

    <h2>Transaction Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" required><br>

        <label for="transaction_type">Transaction Type:</label>
        <select name="transaction_type" required>
            <option value="deposit">Deposit</option>
            <option value="withdrawal">Withdrawal</option>
        </select><br>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" required><br>

        <input type="submit" value="Perform Transaction">
    </form>

</body>
</html>