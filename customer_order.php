<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['customer'])) {
    header("Location: loginPage.php"); // Redirect to login page if not logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head class="bg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Cart</title>
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="menu-body">
    <div class="menu-header">
        <div class="menu-header-left">
            <a><img src="images/vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
            <h1>BurgerBytes Cart</h1>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
    <div class="cart-container" style="padding-left: 50px;">
        <div class="cart-back-and-cart" style="display: flex; align-items: center;">
            <a href="menu.php"><img src="images/previous.png" id="previous_button" alt="BACK" style="padding-right: 10px;"></a>
            <h1>Order Details</h1>
        </div>
            <div class="menu-container">

        <?php
        require_once("settings.php");

        // Connect to the database
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get the user's customer ID
        $customer_id = $_SESSION["customer"];

        // Fetch the orders and items for the logged-in user
        $sql = "SELECT 
                    o.order_id,
                    o.total_amt,
                    o.orderdate,
                    o.status,
                    oi.product_name
                FROM 
                    orders o
                JOIN 
                    ordered_item oi ON o.order_id = oi.order_id
                WHERE
                    o.user_id = '$customer_id'
                ORDER BY 
                    o.order_id, oi.product_name";
                    
        $result = mysqli_query($dbconn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<table style="margin: 20px;">';
            echo '<tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Order Date</th>
                    <th>Product</th>
                    <th>Status</th>
                  </tr>';
            
            $current_order_id = null;
            while ($row = mysqli_fetch_assoc($result)) {
                if ($current_order_id != $row['order_id']) {
                    if ($current_order_id !== null) {
                        echo "</ul></td></tr>";
                    }
                    $current_order_id = $row['order_id'];
                    echo '<tr>
                            <td>' . htmlspecialchars($row['order_id']) . '</td>
                            <td>' . htmlspecialchars($row['total_amt']) . '</td>
                            <td>' . htmlspecialchars($row['orderdate']) . '</td>
                            <td>' . htmlspecialchars($row['status']) . '</td>
                            <td><ul>';
                }
                echo '<li>' . htmlspecialchars($row['product_name']) . '</li>';
            }
            echo "</ul></td></tr>";
            echo '</table>';
        } else {
            echo "<p>No orders found.</p>";
        }

        mysqli_close($dbconn);
        ?>
        </div>
    </div>
    <?php require("product/footer.php"); ?>
</body>
</html>
