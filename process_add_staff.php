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

    // Insert the new staff member into the database
    $sql = "INSERT INTO staff (staffid, fname, lname, email, password, access_level) VALUES ('$staffid', '$fname', '$lname', '$email', '$password', '$role')";

    if (mysqli_query($dbconn, $sql)) {
        echo "New staff member added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($dbconn);
    }

    // Close the database connection
    mysqli_close($dbconn);

    // Redirect back to the staff management page or any other page
    header("Location: managestaff.php");
    exit();
}
?>
