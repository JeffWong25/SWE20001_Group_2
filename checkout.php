<?php
session_start(); // Start the session
// Check if the user is logged in
if (!isset($_SESSION['customer'])) {
    header("Location: loginPage.php"); // Redirect to login page if not logged in
    exit;
}
?>

<?php
    require_once("settings.php");
    //connection
    $dbconn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $customer_id = $_SESSION["customer"];
    // Fetch cart from the database
    $sql = "SELECT cart_id, menu_items.item_name, menu_items.imgpath, menu_items.`desc`, menu_items.price, comment, minus_button
                    FROM cart
                    JOIN menu_items
                    ON cart.menu_items = menu_items.item_id
                    WHERE cart.purchaser = '$customer_id'
                    ORDER BY cart.menu_items";
    $sql2 ="SELECT item_name, imgpath, 'desc' FROM menu_items";
    //$sql1 = "SELECT subtotal FROM order_items";
    $result = $dbconn->query($sql);
    $result2 = $dbconn->query($sql2);
?>
<!DOCTYPE html>
<html lang="en">
    <head class="bg">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BurgerBytes Checkout</title>
        <link rel="stylesheet" href="styling/style.css">
        <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="scripts/minus_cart.js"></script>
    </head>

    <body class = "payment-background">
    <div class="menu-header">
        <div class="menu-header-left">
            <a><img src="images\vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
            <h1>BurgerBytes Checkout</h1>
        </div>
       <a href="logout.php" class="logout-button">Logout</a>
    </div>
        <table class="table_font">
        <tr>
            <th colspan ="5">Order Preview</th>
        </tr>
        <tr id ='noborder'>
            <th id ='noborder'>Image</th>
            <th id ='noborder'>Food/Beverage</th>
            <th id ='noborder'>Price</th>
            <th id ='noborder'>Comment</th>
        </tr>
        <?php
         $subtotal = 0; // Initialize subtotal variablesss
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $total = $row['price']; // Calculate total for each item
                $subtotal += $total; // Add to subtotal
                echo "<tr id ='noborder'>
                <td id='noborder'><img src='{$row['imgpath']}' alt='{$row['item_name']}' style='width: 100px; height: 100px; max-width: 100px; max-height: 100px;'></td>
                        <td id ='noborder'>{$row['item_name']}</td>
                        <td id='noborder'>RM {$row['price']}</td>
                        <td id ='noborder'>{$row['comment']}</td>

                      </tr>
                      ";
            }
        } else {
            echo "<tr><td id = 'noborder'colspan='6'style='text-align: center;'>Your cart is empty</td></tr>";
        }
        ?>
        </table>
        <hr id ="hr_style">
        <table class="table_font1">
        <?php
            // Display the subtotal
            if ($result->num_rows > 0) {
                echo "<tr>
                        <td id='noborder'>Subtotal</td>
                        <td id='noborder'>RM {$subtotal}</td>
                      </tr>";
            }
            $dbconn->close();
            ?>
        </table>
    <div class="payment-methods">
        <h2>Select Payment Method</h2>
        <form id="payment-form" action="cash.php" method="POST">
            <label>
                <input type="radio" name="payment_method" value="cash" required>
                Cash on Cashier
            </label><br>
            <!-- <label>
                <input type="radio" name="payment_method" value="maybank">
                Maybank
            </label><br>
            <label>
                <input type="radio" name="payment_method" value="touchngo">
                Touch 'n Go
            </label><br><br> -->
            <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
            <div class="form-buttons">
                <button type="submit" class="proceed-button" <?php echo ($result->num_rows == 0) ? 'disabled' : ''; ?>>Proceed to Payment</button>

                <a href="menu.php"><button type="button" class="return-button">Return to Menu</button></a>
            </div>
        </form>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
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
