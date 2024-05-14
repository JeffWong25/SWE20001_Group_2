<?php
require_once("settings.php");

// Connection
$dbconn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_item_id'])) {
    $order_item_id = $_POST['order_item_id'];

    // Delete the order item from the database
    $sql = "DELETE FROM order_items WHERE order_item_id = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("i", $order_item_id);

    if ($stmt->execute()) {
        echo "Order item successfully canceled.";
    } else {
        echo "Error canceling order item: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$dbconn->close();
header("Location: checkout.php");
exit();
?>
