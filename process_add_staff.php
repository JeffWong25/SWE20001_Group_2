<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database settings file
    require_once("settings.php");

    // Get form data
    $staffid = $_POST['staffid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role'];

    // Create a database connection
    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);

    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check for duplicate staffid or email
    $check_sql = "SELECT * FROM staff WHERE staffid = '$staffid' OR email = '$email'";
    $result = mysqli_query($dbconn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Duplicate found
        echo "<script>
                alert('Error: A staff member with the same ID or email already exists.');
                window.history.back();
              </script>";
    } else {
        // No duplicate found, proceed with the insertion
        $sql = "INSERT INTO staff (staffid, fname, lname, email, password, access_level) VALUES ('$staffid', '$fname', '$lname', '$email', '$password', '$role')";

        if (mysqli_query($dbconn, $sql)) {
            echo "<script>
                    alert('New staff member added successfully!');
                    window.location.href = 'managestaff.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error: " . mysqli_error($dbconn) . "');
                    window.history.back();
                  </script>";
        }
    }

    // Close the database connection
    mysqli_close($dbconn);
}
?>
