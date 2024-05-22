<?php
session_start();
require_once("settings.php");
//connection
$dbconn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch orders from the database
$sql = "SELECT order_id, user_id, total_amt, orderdate, status FROM orders";
$result = $dbconn->query($sql);
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
    <div class="menu-header">
        <a><img src="images\vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
        <h1>BurgerBytes</h1>
    </div>
        <h1>Order List</h1>
        <table class="table_font">
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
        $dbconn->close();
        ?>
    </table>




























    </body>
</html>
