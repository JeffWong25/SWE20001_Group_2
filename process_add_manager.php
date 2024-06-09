<?php
require_once('settings.php');
$dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);

if (!$dbconn) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = mysqli_real_escape_string($dbconn, $_POST['fname']);
    $lname = mysqli_real_escape_string($dbconn, $_POST['lname']);
    $email = mysqli_real_escape_string($dbconn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Securely hash the password

    $sql = "INSERT INTO staff (fname, lname, email, password, access_level) VALUES ('$fname', '$lname', '$email', '$password', 'manager')";

    if (mysqli_query($dbconn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Manager added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($dbconn)]);
    }

    mysqli_close($dbconn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
