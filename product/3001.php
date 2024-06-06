<!DOCTYPE html>
<html lang="en">
<head class="bg"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Product</title>
    <link rel="stylesheet" href="../styling/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
    <script>
    function addToCart(element) {
        const itemId = element.getAttribute('data-item-id');
        const preference = document.getElementById('textbox_id').value;
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_to_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText); // Display response from server
                window.location.href = '../menu.php';
            }
        };
        xhr.send('item_id=' + itemId + '&preference=' + encodeURIComponent(preference));
    }

    // Event listener for product_page_add elements
    const addToCartButtons = document.querySelectorAll('.product_page_add');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            window.location.href = '../menu.php'; // Redirect to menu.php
        });
    });
</script>

</head>
<body class="menu-body">
    <div class="menu-header">
        <a href="#"><img src="../images/vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
        <h1>BurgerBytes Products</h1>
    </div>
    <div class="product_page">
        <?php
            session_start();

            if (isset($_SESSION["customer"])) {
                require_once("../settings.php");
                $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
                if (!$dbconn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT email FROM customers WHERE user_id = '{$_SESSION["customer"]}'";
                $result = mysqli_query($dbconn, $sql);
                $customer = mysqli_fetch_assoc($result);

             
                if ($customer) {
                    $customer_email = $customer["email"];
                } else {
                    // Handle case where customer is not found
                    $customer_email = "Email not found";
                }


                mysqli_close($dbconn);
            } else {
                // Handle case where session is not set
                $customer_email = "No customer logged in";
            }
            
            //display customer email
            //echo "<p>Customer Email: " . htmlspecialchars($customer_email) . "</p>";

            require_once("../settings.php");
            $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
            if (!$dbconn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT item_name, imgpath, `desc`, price, item_id FROM menu_items WHERE item_id = 3001";
            $result = mysqli_query($dbconn, $sql);

            echo "<table style='margin: 20px;'>";
            if ($row = mysqli_fetch_assoc($result)) {
                require("add_to_cart_table.php");
            }
            echo "</table>";

            mysqli_close($dbconn);
        ?>
    </div>
    <?php require("footer.php"); ?>
</body>
</html>
