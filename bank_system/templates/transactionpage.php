<?php
require_once('../classes/database.php');
require_once('../classes/transactions.php');

$db = Database::getInstance();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender = $_POST["sender"];
    $receiver = $_POST["receiver"];
    $amount = $_POST["amount"];

    $transaction = new Transaction($db, $sender, $receiver, $amount);

    $transaction->performTransaction();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Page</title>
    <link rel="stylesheet" href="transaction.css">
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="sender">Sender:</label>
        <input type="text" name="sender" required><br>

        <label for="receiver">Receiver:</label>
        <input type="text" name="receiver" required><br>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" required><br>

        <input type="submit" value="Perform Transaction">
    </form>

</body>
</html>