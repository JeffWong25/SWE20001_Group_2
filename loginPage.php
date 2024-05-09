<!Doctype HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--CSS-->
        <link rel="stylesheet" href="styling/style.css">
        <title>Log In</title>
    </head>

    <body class="login-body">

    <div class="login-box" method="post">
        <h2>Log In</h2>
        <form action="menu.php">

            <div class="input-box">
                <input type="text" name="user" placeholder="User Id" required>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">Log In</button>

            <div class="links">Don't have an account? <a href="signupPage.php">Sign Up</a></div>            
        </form>
    </div>


        <?php
$servername = "localhost:4306"; // Change this to your MySQL server address
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "sweproject_db"; // Change this to your MySQL database name

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "Connected successfully";
} catch (Exception $e) {
    // Check if the error is due to an incorrect password
    if (strpos($e->getMessage(), "Access denied") !== false) {
        die("Incorrect password");
    } else {
        die($e->getMessage());
    }
}
?>


    </body>
</html>   