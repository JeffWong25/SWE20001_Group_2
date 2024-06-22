<!DOCTYPE html>
<html lang="en">
<head class="bg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Manager Menu</title>
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="scripts/menu.js"></script>
</head>
<body class="menu-body">
    <div class="menu-header">
        <div class="menu-header-left">
            <a><img src="images/vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
            <h1>BurgerBytes Menu</h1>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <div class="menu-container">
        <div>
            <div class="menu-nav">
                <a href="kitchen.php">Pending</a>
                <a href="kitchen1.php">Prepared</a>
            </div>
            <?php
                session_start();
                require_once("settings.php");
                
                // Connection
                $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
                if (!$dbconn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Update order status if form is submitted
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['new_status'])) {
                    $order_id = $_POST['order_id'];
                    $new_status = $_POST['new_status'];
                    $update_sql = "UPDATE orders SET status = ? WHERE order_id = ?";
                    $stmt_update = $dbconn->prepare($update_sql);
                    $stmt_update->bind_param("si", $new_status, $order_id);
                    $stmt_update->execute();
                    $stmt_update->close();
                }

                // SQL query to fetch the data
                $sql = "
                    SELECT o.order_id, o.user_id, o.orderdate, o.status, oi.order_id AS oi_order_id, oi.product_name, oi.product AS oi_product_id
                    FROM orders o
                    LEFT JOIN ordered_item oi ON o.order_id = oi.order_id
                    WHERE o.status = 'PENDING'
                    ORDER BY o.order_id, oi.product
                ";
                $result = mysqli_query($dbconn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $current_order_id = null;
                    echo "<table border='1'>
                            <tr>
                                <th>Order ID</th>
                                <th>User ID</th>
                                <th>Order Date</th>
                                <th>Status</th> 
                                <th>Items</th>
                            </tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($current_order_id != $row['order_id']) {
                            if ($current_order_id !== null) {
                                echo "</ul></td></tr>";
                            }
                            $current_order_id = $row['order_id'];
                            echo "<tr>
                                    <td>{$row['order_id']}</td>
                                    <td>{$row['user_id']}</td>
                                    <td>{$row['orderdate']}</td>
                                    <td>
                                        <form method='POST' action='kitchen1.php'>
                                            <select name='new_status'>
                                                <option value='PENDING' " . ($row['status'] == 'PENDING' ? 'selected' : '') . ">PENDING</option>
                                                <option value='COMPLETE' " . ($row['status'] == 'COMPLETE' ? 'selected' : '') . ">COMPLETE</option>
                                            </select>
                                            <input type='hidden' name='order_id' value='{$row['order_id']}'>
                                            <button type='submit'>Update</button>
                                        </form>
                                    </td>
                                    <td><ul>";
                        }
                        echo "<li>{$row['product_name']} (Item ID: {$row['oi_product_id']})</li>";
                    }
                    echo "</ul></td></tr></table>";
                } else {
                    echo "<p>No orders found.</p>";
                }

                mysqli_close($dbconn);
            ?>
        </div>
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
