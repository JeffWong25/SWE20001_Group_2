<?php
    session_start();
    require_once("settings.php");
    //connection
    $dbconn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Fetch cart items from the database
    $sql = "SELECT cart_id, menu_items, add_cart_date, comment FROM cart";
    $result = $dbconn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
    <head class="bg">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BurgerBytes checkout</title>
        <link rel="stylesheet" href="styling/style.css">
        <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="scripts/menu.js"></script>
    </head>
    <body class= "checkout_background">
    <div class="menu-header">
        <a><img src="images\vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
        <h1>BurgerBytes</h1>
    </div>
        <table class="table_font">
        <tr>
            <th colspan ="5">Order Preview</th>
        </tr>
        <tr id ='noborder'>
            <th id ='noborder'>Cart ID</th>
            <th id ='noborder'>Menu item</th>
            <th id ='noborder'>Add Cart Date</th>
            <th id ='noborder'>Comment</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr id ='noborder'>
                        <td id ='noborder'>{$row['cart_id']}</td>
                        <td id ='noborder'>{$row['menu_items']}</td>
                        <td id ='noborder'>{$row['add_cart_date']}</td>
                        <td id ='noborder'>{$row['comment']}</td>
                        <td id='noborder'>
                                "/*remove cart items*/,"
                                <form action='cancel_cart_items.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='cart_id' value='{$row['cart_id']}'>
                                    <input type='submit' value='Remove'>
                                </form>
                        </td>
                      </tr>
                      ";
            }
        } else {
            echo "<tr id ='noborder'><td colspan='6' id ='noborder'>No orders found</td></tr>";
        }
        $dbconn->close();
        ?>
        </table>
        <!-- <hr id ="hr_style">
        <table class="table_font1">
        <?php
        // if ($result1->num_rows > 0) {
        //     while($row = $result1->fetch_assoc()) {
        //         echo "
        //               <tr>
        //               <td id ='noborder'>Subtotal</td>
        //               <td id ='noborder'>{$row['subtotal']}</td>
        //               </tr>
        //               ";
        //     }
        // } else {
        //     echo "<tr id ='noborder'><td colspan='6' id ='noborder'>No orders found</td></tr>";
        // }
        ?>
        </table>  -->
        <div class="checkout_button_container">
        <form action="process_payment.php" method="POST">
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <label for="cash" class ="radio_button_container">Cash on Cashier
                 <input type="radio" name="payment_method" value="cash" id="cash">
                 <span class="checkmark"></span>
            </label>
            <br>
            <label for="maybank" class ="radio_button_container">Maybank
                <input type="radio" name="payment_method" value="maybank" id="maybank">
                <span class="checkmark"></span>
            </label>
            <br>
            <label for="tng" class ="radio_button_container">Touch 'n Go
                <input type="radio" name="payment_method" value="tng" id="tng">
                <span class="checkmark"></span>
            </label>
            <br><br>
            <input type="submit" class="checkout_button" value="Proceed to Payment">
            <a href="menu.php"><input class="checkout_button" type="button" value="Back"></a>
        </form>
        </div>

    </body>
</html>
