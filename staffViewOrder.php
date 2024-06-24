<?php
session_start();
if (isset($_SESSION["staff"]) && $_SESSION["accesslevel"] === 'cashier'){
    require_once("settings.php");
    //connection
    $dbconn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }
}   
// Fetch orders from the database
$sql = "SELECT order_id, user_id, total_amt, orderdate, status FROM orders";
$result = $dbconn->query($sql);

$sql = "SELECT *  FROM staff
WHERE staffid = '{$_SESSION["staff"]}'";

$result2 = mysqli_query($dbconn, $sql);
$staff = $result2->fetch_assoc();
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
    <body class="menu-body">
        <div class="menu-header">
            <div class="menu-header-left">
                <a><img src="images\vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
                <h1>BurgerBytes Menu</h1>
            </div>
            <a href="staffLogout.php" class="logout-button">Logout</a>
        </div>

        <div id="welcome-container">
        <?php if (isset($staff)): ?>
            <div id="welcome-message">
            <p>Welcome, <?= htmlspecialchars($staff["fname"]) ?>!</p>
            <p>Orders are ready to be picked up!</p>
            </div>
        <?php endif; ?>
        </div>

        <div>
            <h1><center>Order List</center></h1>
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
