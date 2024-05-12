<?php
// Initialize validation and preparation error flags
$validation_error = false;
$preparation_error = false;

// Check if the form was submitted through POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check that all input fields are filled
    if (empty($_POST["fname"]) || empty($_POST["lname"]) || empty($_POST["phonenumber"]) || empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["confirm-password"])) {
        $validation_error = true;
    }

    // Check for specific input formats 
    if (!preg_match("/^[a-zA-Z]{1,50}$/", $_POST["fname"]) || !preg_match("/^[a-zA-Z]{1,50}$/", $_POST["lname"]) || !preg_match("/^\d{3}-\d{7}$/", $_POST["phonenumber"]) || !preg_match("/^[a-zA-Z0-9]{5,20}$/", $_POST["username"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $validation_error = true;
    }

    // Check if passwords are matching
    if ($_POST["password"] !== $_POST["confirm-password"]) {
        $validation_error = true;
    }

    // If no validation errors, proceed with database insertion
    if (!$validation_error) {

        //Connect to database 
        require_once("settings.php");
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        //Prepare SQL query for execution   
        //Placeholders(?) are used to keep the user input data separate from the SQL query
        //Help prevent SQL injection attacks     
        $sql = "INSERT INTO `customers`(`username`, `fname`, `lname`, `password`, `email`, `phonenumber`) 
                VALUES (?, ?, ?, ?, ?, ?)";
                
        //Prepare SQL statement
        $stmt = mysqli_prepare($dbconn, $sql);
        if (!$stmt) {
            $preparation_error = true;
        }
        // If preparation error occurs, set message
        if ($preparation_error) {
            $message = "An error occurred. Please try again later.";
            $class = "error";
        } else {
            // Generate hash to store password securely  
            $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            // Bind parameters to the placeholders
            mysqli_stmt_bind_param($stmt, "ssssss", $_POST["username"], $_POST["fname"], $_POST["lname"], $hashed_password, $_POST["email"], $_POST["phonenumber"]);

            // Execute SQL statement
            try {   
                if (mysqli_stmt_execute($stmt)) {
                $message = "Account successfully created";
                $class = "success";
            } else {
            // Check if the email is already in use
                if (mysqli_errno($dbconn) == 1062) {
                $message = "An account with this email already exists";
                $class = "creationError";
                } else {
                $message = "Account creation failed";
                $class = "creationError";
                    }
            }   
        } catch (mysqli_sql_exception $e) {
            if (mysqli_errno($dbconn) == 1062) {
                $message = "An account with this email already exists";
                $class = "creationError";
            } else {
                $message = "An error occurred. Please try again later.";
                $class = "creationError";
            }
        }

            // Close statement and database connection
            mysqli_stmt_close($stmt);
            mysqli_close($dbconn);
        }
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/style.css">
    <script src="scripts/loginSignupValidation.js"></script>
    <title>Account Creation</title>
</head>

<body class="login-body">
<div class="login-box">
    <form>
        <?php if (isset($message)) : ?>
            <p class="<?php echo $class; ?>"><?php echo $message; ?></p>
            <?php if ($class === "creationError") : ?>
                <div class="goToNext"><a href="signupPage.php">Use Different Email</a></div>
                <div class="goToNext"><a href="loginPage.php">Go to Log In</a></div>
            <?php else : ?>
                <div class="goToNext"><a href="loginPage.php">Log In Now</a></div>
            <?php endif; ?>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
