<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['customer'])) {
    header("Location: loginPage.php"); // Redirect to login page if not logged in
    exit;
}

require_once("settings.php");

// Connection
$dbconn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming you store the user's email or username in the session
    $user_email = $_SESSION['customer']; // Change this to the appropriate session variable

    // Fetch the user ID from the database
    $get_user_sql = "SELECT user_id FROM customers WHERE email = ?";
    $stmt_get_user = $dbconn->prepare($get_user_sql);
    $stmt_get_user->bind_param("s", $user_email);
    $stmt_get_user->execute();
    $result_get_user = $stmt_get_user->get_result();

    if ($result_get_user->num_rows == 0) {
        echo "Error: User not found.";
        exit;
    }

    $user_row = $result_get_user->fetch_assoc();
    $user_id = $user_row['user_id'];

    $stmt_get_user->close();

    $subtotal = isset($_POST['subtotal']) ? $_POST['subtotal'] : 0.0;
    $payment_method = $_POST['payment_method'];

    // // Debugging output
    // echo "User ID: " . $user_id . "<br>";
    // echo "Subtotal: " . $subtotal . "<br>";
    // echo "Payment Method: " . $payment_method . "<br>";

    // Step 1: Insert into orders table
    $orderdate = date('Y-m-d H:i:s');
    $status = 'PENDING';
    $insert_order_sql = "INSERT INTO orders (user_id, total_amt, orderdate, status) VALUES (?, ?, ?, ?)";
    $stmt = $dbconn->prepare($insert_order_sql);
    $stmt->bind_param("idss", $user_id, $subtotal, $orderdate, $status);

    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
        exit;
    }

    // Get the newly inserted order ID
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Step 2: Insert into order_items table
    $select_cart_sql = "
        SELECT oi.item_id, oi.quantity, mi.price
        FROM order_items oi
        JOIN menu_items mi ON oi.item_id = mi.item_id
        JOIN orders o ON oi.order_id = o.order_id
        WHERE o.user_id = ?
    ";
    $stmt = $dbconn->prepare($select_cart_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $item_id = $row['menu_items'];
        $quantity = 1; // Assuming quantity is 1 per cart item
        $item_price = $row['price']; // Assuming item price is stored in the cart table
        $subtotal_item = $item_price * $quantity; // Calculate subtotal for each item

        $insert_order_items_sql = "INSERT INTO order_items (order_id, item_id, quantity, subtotal) VALUES (?, ?, ?, ?)";
        $stmt_insert = $dbconn->prepare($insert_order_items_sql);
        $stmt_insert->bind_param("iiid", $order_id, $item_id, $quantity, $subtotal_item);
        $stmt_insert->execute();
        $stmt_insert->close();
    }
    $stmt->close();

    // // Step 3: Clear the cart for the current user
    $clear_cart_sql = "DELETE FROM cart";
    $stmt = $dbconn->prepare($clear_cart_sql);
    $stmt->execute();
    $stmt->close();

    $dbconn->close();

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Payment Confirmation</title>
        <link rel='stylesheet' href='styling/style.css'>
    </head>
    <body class='payment-background'>
        <div class='menu-header'>
        <div class='menu-header-left'>
            <a><img src='images/vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png' id='logo' alt='BurgerBytes logo' width='80'></a>
            <h1>BurgerBytes</h1>
        </div>
            <a href='logout.php' class='logout-button'>Logout</a>
        </div>
        <div class='payment-methods'>
            <h2>Order Successful!</h2>
            <p>Your order has been successfully processed. Please pay in {$subtotal} at the counter.</p>
            <div class='form-buttons'>
            <a href='menu.php'><button class='return-button'>Return to Menu</button></a>
            </div>
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

        <footer class='menu-footer'>
            <div class='menu-footer-content'>
                <div class='menu-footer-left'>
                <p>&copy; 2024 BurgerBytes. All rights reserved.</p>
                </div>
                <div class='menu-footer-right'>
                <p>Contact Us: burgerbytes@gmail.com</p>
                </div>
            <div>
        </footer>
    </body>
    </html>";
}
?>

