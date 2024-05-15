<?php
require_once("settings.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_item_id = $_POST['cart_id'];

    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM cart WHERE cart_id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("i", $cart_item_id);

    if ($stmt->execute()) {
        echo "Item removed from cart successfully.";
    } else {
        echo "Error removing item from cart: " . $stmt->error;
    }

    $stmt->close();
    $dbconn->close();
    header("Location: checkout.php");
    exit();
}
?>
