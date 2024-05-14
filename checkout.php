<?php
    session_start();
    require_once("settings.php");
    //connection
    $dbconn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Fetch orders from the database
    $sql = "SELECT order_item_id, order_id, item_id, quantity, subtotal FROM order_items";
    $sql1 = "SELECT subtotal FROM order_items";
    $result = $dbconn->query($sql);
    $result1 = $dbconn->query($sql1);
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
    <body class= "checkout_background">
        <div class="checkout_content">
        <table class="table_font">
        <tr>
            <th colspan ="5">Order Preview</th>
        </tr>
        <tr id ='noborder'>
            <th id ='noborder'>Order Item ID</th>
            <th id ='noborder'>Order ID</th>
            <th id ='noborder'>Item ID</th>
            <th id ='noborder'>Quantity</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr id ='noborder'>
                        <td id ='noborder'>{$row['order_item_id']}</td>
                        <td id ='noborder'>{$row['order_id']}</td>
                        <td id ='noborder'>{$row['item_id']}</td>
                        <td id ='noborder'>{$row['quantity']}</td>
                        <td id='noborder'>
                                "/*cancel order*/,"
                                <form action='cancel_order.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='order_item_id' value='{$row['order_item_id']}'>
                                    <input type='submit' value='Cancel'>
                                </form>
                        </td>
                      </tr>
                      ";
            }
        } else {
            echo "<tr id ='noborder'><td colspan='6' id ='noborder'>No orders found</td></tr>";
        }
        ?>
        </table>
        <hr id ="hr_style">
        <table class="table_font1">
        <?php
        if ($result1->num_rows > 0) {
            while($row = $result1->fetch_assoc()) {
                echo "
                      <tr>
                      <td id ='noborder'>Subtotal</td>
                      <td id ='noborder'>{$row['subtotal']}</td>
                      </tr>
                      ";
            }
        } else {
            echo "<tr id ='noborder'><td colspan='6' id ='noborder'>No orders found</td></tr>";
        }
        $dbconn->close();
        ?>
    </table>
    <a href="payment.php"><input type="button" value="Pay Now"></a>
    <a href="menu.php"><input type="button" value="Back"></a>
    </div>
    </body>
</html>
