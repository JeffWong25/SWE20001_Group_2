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
    <script>
        function minusCart(element) {
        const cart_id = element.getAttribute('data-item-id');
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'minus_from_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText === 'success') {
                    // Reload the page
                    location.reload();
                } else {
                    alert('An error occurred while removing the item from the cart.');
                }
            }
        };
        xhr.send('cart_id=' + cart_id);
        }

    </script>
    <style>
        .checkout-button {
            width: 100%;
            font-size: 25px;
            font-weight: bold;
            background: linear-gradient(45deg, #F81B15, #FDC400);
            color: #fff;
            padding: 10px;
            border: none;
            margin: 10px 0px;
            border-radius: 20px;
            cursor: pointer;
            transition: 0.2s;
            text-align: center;
            text-decoration: none; /* Ensure the link text has no underline */
            display: inline-block; /* Ensure the button is displayed inline */
        }

        .checkout-button:active {
            transform: scale(0.9);
        }

        .checkout-button a {
            color: #fff; /* Ensure the link text is white */
            text-decoration: none; /* Ensure the link text has no underline */
            display: block; /* Ensure the link fills the button */
            width: 100%; /* Ensure the link takes full width */
            height: 100%; /* Ensure the link takes full height */
        }
    </style>
</head>
<body class="menu-body">
    <div class="menu-header">
        <div class="menu-header-left">
            <a><img src="images\vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
            <h1>BurgerBytes Cart</h1>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
    <div class="cart-container" style="padding-left: 50px;">
        <div class ="cart-back-and-cart" style="display: flex; align-items: center;">
            <a href="menu.php"><img src="images\previous.png" id="previous_button" alt="BACK" style="padding-right: 10px;"></a>
            <h1>Your Cart</h1>
        </div>
        <?php
        require_once("settings.php");
        
        // Connect to the database
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get the user's customer ID
        $customer_id = $_SESSION["customer"];

        // Fetch the items in the cart for the logged-in user
        $sql = "SELECT cart_id, menu_items.item_name, menu_items.imgpath, menu_items.`desc`, cart.comment, minus_button
                FROM cart
                JOIN menu_items ON cart.menu_items = menu_items.item_id
                WHERE cart.purchaser = '$customer_id'
                ORDER BY cart.menu_items";
        $result = mysqli_query($dbconn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<table style="margin: 20px; border= 1;">';
            echo '<tr>
                    <th>Item Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Comment</th>
                  </tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                require("cart_table.php");
            }
            echo '</table>';
        } else {
            echo "<p>Your cart is empty</p>";
        }

        mysqli_close($dbconn);
        ?>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <button class="checkout-button"><a href="checkout.php">Checkout</a></button>
        <?php endif; ?>
    </div>
    <?php require("product/footer.php"); ?>
</body>
</html>
