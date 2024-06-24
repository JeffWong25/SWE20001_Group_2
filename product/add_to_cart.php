<?php
require_once("../settings.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'];
    $preference = $_POST['preference'];
    $customer_email = $_POST['customer_email'];

    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch the user_id based on the provided email
    $sql = "SELECT user_id FROM customers WHERE email = '$customer_email'";
    $result = mysqli_query($dbconn, $sql);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Insert the cart item
        $sql_insert = "INSERT INTO cart (menu_items, add_cart_date, comment, purchaser) 
                       VALUES ('$item_id', CURRENT_TIMESTAMP, '$preference', '$user_id')";

        if (mysqli_query($dbconn, $sql_insert)) {
            echo "Item added to cart successfully";
        } else {
            echo "Error: " . $sql_insert . "<br>" . mysqli_error($dbconn);
        }
    } else {
        echo "Error: Unable to find customer with the provided email.";
    }

    mysqli_close($dbconn);
}
?>
