<?php
require_once('../classes/database.php');
require_once('../classes/signup.php');

$db = Database::getInstance();

$signup = new Signup($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Call the createUser method to insert the user into the database
    $result = $signup->createUser($username, $email, $password);

    if (strpos($result, "successfully") !== false) {
        header("Location: homepage.php"); // Redirect to the homepage
        exit(); // Ensure that no further code is executed after the header
    }

    // Output the result if the signup was not successful
    echo $result;
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
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
