<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS-->
    <link rel="stylesheet" href="styling/style.css">
    <script src="scripts/loginSignupValidation.js"></script>
    <title>Register Account</title>
</head>

<body class="login-body">
<div class="login-box">
    <h2>Register</h2>

    <form action="loginPage.php" method="post" onsubmit="return validateForm()">

        <div class="input-box">
            <input type="text" name="fname" id="fname" placeholder="First Name" required>
        </div>
        <div class="error" id="fname-error-message"></div>


        <div class="input-box">
            <input type="text" name="lname" id="lname" placeholder="Last Name" required>
        </div>
        <div class="error" id="lname-error-message"></div>

        <div class="input-box">
            <input type="text" name="phonenumber" id="phonenumber" placeholder="Phone Number" required>
        </div>
        <div class="error" id="phonenumber-error-message"></div>


        <div class="input-box">
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>
        <div class="error" id="user-error-message"></div>

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
