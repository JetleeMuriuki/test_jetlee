
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
<label for="username">Username:</label>           
<input type="text" id="username" name="username" required>           
<label for="password">Password:</label>           
<input type="password" id="password" name="password" required>
<button type="submit">Login</button>       
</form>
        <a href="#">Forgot password?</a>
    </div>
</body>
</html>
<?php
// Include the Login class
require_once 'Login.php';

// Initialize the Login class
$login = new Login();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authenticate user
    if ($login->authenticate($username, $password)) {
        echo 'Authentication successful. Welcome, ' . htmlspecialchars($username) . '!';
        // Redirect to a dashboard or another page after successful login
        // header('Location: dashboard.php');
        // exit();
    } else {
        echo 'Authentication failed. Please check your username and password.';
    }
}
?>