<?php
    $is_invalid = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once("settings.php");
        $dbconn = mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Sanitize the input 
        $staff = mysqli_real_escape_string($dbconn, $_POST["staffid"]);

        $sql = "SELECT * FROM staff WHERE staffid = '$staff'";
        $result = mysqli_query($dbconn, $sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($dbconn));
        }

        // Fetch the result as an associative array
        $user = mysqli_fetch_assoc($result);

        // Check if a user with the given staff ID exists and if the password matches
        if ($user) {
            //CHANGE BACK TO THIS ONVE IMPLEMENT HASHED PASSWORD
           // if (password_verify($_POST["password"], $user["password"])) 
           if ($_POST["password"] === $user["password"]){
                session_start();
                // Regenerate session ID to help prevent fixation attacks
                session_regenerate_id();
                $_SESSION["staff"] = $user["staffid"];

                $_SESSION["accesslevel"] = $user["access_level"];

                // Redirect based on access level
                switch ($user["access_level"]) {
                    case 'manager':
                        header("Location: manager.php");
                        break;
                    case 'kitchen':
                        header("Location: kitchen.php");
                        break;
                    case 'cashier':
                        header("Location: staffViewOrder.php");
                        break;
                    default:
                        header("Location: staffViewOrder.php");
                        break;
                }
                exit;    
            } else {
                $is_invalid = true;
            }
        } else {
            $is_invalid = true;
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
        <title>Log In</title>
    </head>

    <body class="login-body">
        <div class="login-box">
            <h2>Log In</h2>

            <!-- Displays when login credentials invalid -->
            <?php if ($is_invalid): ?>
                <em class="error">Invalid Login</em>
            <?php endif; ?>

            <form method="post">
                <div class="input-box">
                    <input type="text" name="staffid" id="staffID" placeholder="Staff ID" required
                        value="<?php echo htmlspecialchars($_POST["staffid"] ?? "") ?>">
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit">Log In</button>
            </form>
        </div>
    </body>
</html>
