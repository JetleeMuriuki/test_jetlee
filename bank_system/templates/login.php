<?php
require_once('../classes/database.php');
require_once('../classes/login.php');

$db = Database::getInstance();


$login = new Login($db);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Call the authenticateUser method to check login credentials
    if ($login->authenticateUser($email, $password)) {
        echo "Login successful";
        // Redirect to the user's dashboard or another page
         header("Location: homepage.php");
         exit();
    } else {
        echo "Login failed";
    }
}
?>

<!DOCTYPE html>

<html lang="en">
<head>   
<metacharset="UTF-8">   
<metaname="viewport" content="width=device-width, initial-scale=1.0">

    
<title>Login Page</title>

    
<link rel="stylesheet" href="login.css">
</head>
<body>

    
<div class="container">
    <h1>Login</h1>
    <form action="homepage.php" method="post">            
<label for="email">Email:</label>           
<input type="email" id="email" name="email" required>           
<label for="password">Password:</label>           
<input type="password" id="password" name="password" required>
<button type="submit">Login</button>       
</form>
        <a href="#">Forgot password?</a>
    </div>
</body>
</html>