<?php
// Include necessary files
require_once '../classes/database.php';
require_once '../classes/signup.php';

$database = new Database();

$signup = new Signup($database);

// Check if the signup form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get username and password from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $registrationResult = $signup->createUser($username, $email, $password);

    echo "<p>{$registrationResult}</p>";
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">   
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up Page</title>   
<link rel="stylesheet" href="login.css">
</head>
<body>
<div class="container">
<h1>Sign Up</h1>
<form action="homepage.php" method="post">
<label for="username">Username:</label>           
<input type="text" id="username" name="username" required>
<label for="email">Email:</label>           
<input type="email" id="email" name="email" required>            
<label for="password">Password:</label>
<input type="password" id="password" name="password" required>
<button type="submit">Sign Up</button>        
</form>
<a href="login.php">Already have an account?</a>
    </div>
</body>
</html>
