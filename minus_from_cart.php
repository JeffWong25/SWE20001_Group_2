<?php
require_once("settings.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];

    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM cart WHERE cart_id = '$cart_id'"; // Use $cart_id instead of $item_id

    if (mysqli_query($dbconn, $sql)) {
        echo "success"; // Send success response
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($dbconn);
    }

    mysqli_close($dbconn);
}
?>
