<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS-->
    <link rel="stylesheet" href="styling/style.css">
    <title>Register Account</title>
</head>

<body class="login-body">
<div class="login-box">
    <h2>Register</h2>

    <!--JS Validation for user registration details -->
    <!-- Checks username, email regex, and reconfirms password entered-->
    <script>
        function validateForm() {
            var user = document.getElementById("username").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;
            var passwordErrorMessage = document.getElementById("password-error-message");
            var userErrorMessage = document.getElementById("user-error-message");
            var emailErrorMessage = document.getElementById("email-error-message");

            // Regular expression for user (5 to 20 alphabets or digits)
            var userRegex = /^[a-zA-Z0-9]{5,20}$/;
            // Regular expression for email
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!user.match(userRegex)) {
                userErrorMessage.innerHTML = "Please enter a valid User Id (5 to 20 alphabets or digits)";
                return false;
            } else {
                userErrorMessage.innerHTML = "";
            }

            if (!email.match(emailRegex)) {
                emailErrorMessage.innerHTML = "Please enter a valid email address";
                return false;
            } else {
                emailErrorMessage.innerHTML = "";
            }

            if (password != confirmPassword) {
                passwordErrorMessage.innerHTML = "Passwords do not match";
                return false;
            } else {
                passwordErrorMessage.innerHTML = "";
                return true;
            }
        }
    </script>

    <form action="loginPage.php" method="post" onsubmit="return validateForm()">

        <div class="input-box">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <div class="error" id="user-error-message"></div>
        </div>

        <div class="input-box">
            <input type="text" name="email" id="email" placeholder="Email" required>
        </div>
        <div class="error" id="email-error-message"></div>


        <div class="input-box">
            <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="error" id="password-error-message"></div>


        <div class="input-box">
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Re-enter Password" required>
        </div>

        <button type="submit">Sign Up</button>

        <div class="links">Have an existing account? <a href="loginPage.php">Log In</a></div>
    </form>
</div>

</body>
</html>
