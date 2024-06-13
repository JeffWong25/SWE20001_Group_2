<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Manager Menu</title>
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="scripts/viewHistory.js"></script>
</head>
<body class="menu-body">
    <div class="menu-whole-page">
        <div class="menu-header">
            <div class="menu-header-left">
                <a><img src="images/vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
                <h1>BurgerBytes Menu</h1>
            </div>
            <a href="staffLogout.php" class="logout-button">Logout</a>
        </div>
        <div class="sidebar">
            <a href="manager.php">View Menu</a>
            <a href="additem.php">Add New Item</a>
            <a href="viewOrderHistory.php">View Orders</a>
            <a href="managestaff.php">Manage Staff</a>
            <a href="addstaff.php">Add Staff</a>
            <a href="ManagerOrder.php">View Orders</a>
        </div>

        <?php
session_start();
if (isset($_SESSION["staff"]) && $_SESSION["accesslevel"] === 'manager') {
    require_once("settings.php");
    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM staff WHERE staffid = '{$_SESSION["staff"]}'";
    $result = mysqli_query($dbconn, $sql);
    $customer = $result->fetch_assoc();
?>

    <p></p>
    <div class="menu-container">
        <?php
        // SQL query to fetch order details along with the ordered items and user name
        $sql = "
            SELECT o.order_id, o.user_id, o.orderdate, o.status, oi.order_id AS oi_order_id, oi.product_name, oi.product AS oi_product_id, c.username
            FROM orders o
            LEFT JOIN ordered_item oi ON o.order_id = oi.order_id
            LEFT JOIN customers c ON o.user_id = c.user_id
            WHERE o.status = 'COMPLETE'
            ORDER BY o.order_id, oi.product;
        ";
        $result = mysqli_query($dbconn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $current_order_id = null;
            echo "<table class='menu-table' border='1'>
                        <tr>
                            <th>Order ID</th>
                            <th>Username</th>
                            <th>Order Date</th>
                            <th>Items</th>
                        </tr>
                    <tbody>";
        
            while ($row = mysqli_fetch_assoc($result)) {
                if ($current_order_id != $row['order_id']) {
                    if ($current_order_id !== null) {
                        echo "</ul></td></tr>";
                    }
                    $current_order_id = $row['order_id'];
                    echo "<tr>
                            <td>{$row['order_id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['orderdate']}</td>
                            <td><ul>";
                }
                echo "<li>{$row['product_name']} (Item ID: {$row['oi_product_id']})</li>";
            }
            echo "</ul></td></tr>
                </tbody>
            </table>";
        } else {
            echo "<p>No orders found.</p>";
        }
        
        mysqli_close($dbconn);
        ?>
    </div>
<?php
} else {
    echo "<p>Please log in as manager to view this page.</p>";
}
?>

    </div>
    <footer class="menu-footer">
        <div class="menu-footer-content">
            <div class="menu-footer-left">
                <p>&copy; 2024 BurgerBytes. All rights reserved.</p>
            </div>
            <div class="menu-footer-right">
                <p>Contact Us: burgerbytes@gmail.com</p>
            </div>
        </div>
    </footer>
</body>
</html>
