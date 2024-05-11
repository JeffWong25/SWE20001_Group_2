
    //For user registration details on signupPage.php
    function validateForm() {

        //Get user inputs values from signup.php
        var fname = document.getElementById("fname").value;
        var lname = document.getElementById("lname").value;
        var phonenumber = document.getElementById("phonenumber").value;
        var user = document.getElementById("username").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm-password").value;

        //Display error messages
        var fnameErrorMessage = document.getElementById("fname-error-message");
        var lnameErrorMessage = document.getElementById("lname-error-message");
        var phonenumberErrorMessage = document.getElementById("phonenumber-error-message");
        var userErrorMessage = document.getElementById("user-error-message");
        var emailErrorMessage = document.getElementById("email-error-message");
        var passwordErrorMessage = document.getElementById("password-error-message");

        // Regex for input validation
        var nameRegex = /^[a-zA-Z]+$/;
        var phoneRegex = /^\d{3}-\d{7}$/;
        var userRegex = /^[a-zA-Z0-9]{5,20}$/;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        //Check user inputs 
        if (!fname.match(nameRegex)) {
            fnameErrorMessage.innerHTML = "Please enter a valid First Name";
            return false;
        } else {
            fnameErrorMessage.innerHTML = "";
        }

        if (!lname.match(nameRegex)) {
            lnameErrorMessage.innerHTML = "Please enter a valid Last Name";
            return false;
        } else {
            lnameErrorMessage.innerHTML = "";
        }

        if (!phonenumber.match(phoneRegex)) {
            phonenumberErrorMessage.innerHTML = "Please enter a valid Phone Number (XXX-XXXXXXX)";
            return false;
        } else {
            phonenumberErrorMessage.innerHTML = "";
        }

        if (!user.match(userRegex)) {
            userErrorMessage.innerHTML = "Please enter a valid User Id (Between 5-20 alphabets/digits)";
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

