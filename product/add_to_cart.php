<?php
require_once("../settings.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $preference = $_POST['preference'];

    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO cart (menu_items, add_cart_date, comment) VALUES ('$item_id', CURRENT_TIMESTAMP, '$preference')";
    
    if (mysqli_query($dbconn, $sql)) {
        echo "Item added to cart successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($dbconn);
    }

    mysqli_close($dbconn);
}
?>