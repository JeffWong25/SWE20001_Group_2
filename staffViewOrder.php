<?php
session_start();
include 'db_connection.php';

// Check if staff is logged in
if (!isset($_SESSION['staff_logged_in'])) {
    header('');
    exit();
}

// Fetch orders from the database
$sql = "SELECT order_id, user_id, total_amt, orderdate, status FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head class="bg">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BurgerBytes Menu</title>
        <link rel="stylesheet" href="styling/style.css">
        <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="scripts/menu.js"></script>
    </head>
    <body>
        <h1>Order List</h1>
        <table border="1">
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Total Amount</th>
            <th>Order Date</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['order_id']}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['total_amt']}</td>
                        <td>{$row['orderdate']}</td>
                        <td>{$row['status']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No orders found</td></tr>";
        }
        $conn->close();
        ?>
    </table>




























    </body>
</html>
