<?php
    $is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("settings.php");
    $dbconn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize the input 
    $email = mysqli_real_escape_string($dbconn, $_POST["email"]);

    
    $sql = "SELECT * FROM customers WHERE email = '$email'";
    $result = mysqli_query($dbconn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($dbconn));
    }

    // Fetch the result as an associative array
    $user = mysqli_fetch_assoc($result);

    // Check if a user with the given email exists and if the password matches
    if ($user){
        if(password_verify($_POST["password"], $user["password"])){
            session_start();
            //regenerate session ID to help prevent fixation attacks
            session_regenerate_id();
            $_SESSION["customer"] = $user["user_id"];
            header("Location: menu.php");
            exit;    
                
        }else{
            $is_invalid = true;
        }
    }
    }
?>

<!Doctype HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styling/style.css">
        <script src="scripts/loginSignupValidation.js"></script>
        <title>Log In</title>
    </head>

    <body class="login-body">

    <div class="login-box">
        <h2>Log In</h2>

        <!-- Displays when login credentials invalid-->
        <?php if ($is_invalid): ?>
            <em class="error">Invalid Login</em>
        <?php endif; ?>

        <form method="post">

            <div class="input-box">
            <input type="email" name="email" id="email" placeholder="Email" required
                    value ="<?php echo htmlspecialchars($_POST["email"] ?? "")?>">            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">Log In</button>

            <div class="links">Don't have an account? <a href="signupPage.php">Sign Up</a></div>            
        </form>
    </div>

    </body>
</html>   