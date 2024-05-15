<!DOCTYPE html>
<html lang="en">
<head class="bg"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Menu</title>
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
</head>
<body class="menu-body">
<div class="menu-header">
        <a><img src="images\vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
        <h1>BurgerBytes Products</h1>
    </div>
<div class="cart-container" style="padding-left: 50px;">
        <h1>Your Cart</h1>
        <table  style="margin: 20px; border=1; " >
            <tr>
                <th>Item Name</th>
                <th>Image</th>
                <th>Description</th>
                <th>Comment</th>
            </tr>
            <?php
            require_once("settings.php");

            // Connect to the database
            $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
            if (!$dbconn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch the combined data from cart and menu_items
            $sql = "SELECT cart_id, menu_items.item_name, menu_items.imgpath, menu_items.`desc`, cart.comment, minus_button 
                    FROM cart 
                    JOIN menu_items 
                    ON cart.menu_items = menu_items.item_id 
                    ORDER BY cart.menu_items";
            $result = mysqli_query($dbconn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    require("cart_table.php");
                }
            } else {
                echo "<tr><td colspan='4'>Your cart is empty</td></tr>";
            }

            mysqli_close($dbconn);
            ?>
        </table>
    </div>
    <?php require("product/footer.php"); ?>
</body>
</html>