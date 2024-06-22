<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Manager Menu</title>
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="scripts/viewHistory.js"></script>
    <style>
        /* Center the order history container */
        .order-history-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 40px auto;
            width: 100%;
            max-width: 800px;
        }
        .filter-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            width: 100%;
        }
        .filter-section form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
            width: 100%;
        }
        .filter-section form div {
            display: flex;
            gap: 10px;
            justify-content: center;
            width: 100%;
        }
        .apply-filters-btn {
            margin-top: 10px;
        }
        .order-history-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border: 1px solid #dddddd;
            margin-bottom: 40px; /* Add space below the table */
        }
        .order-history-table th, .order-history-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        #start_date, #end_date {
            width: 55%; /* Full-width */
            margin-left: 20%;
            font-size: 16px; /* Increase font-size */
            padding: 12px 20px 12px 40px; /* Add some padding */
            border: 1px solid #ddd; /* Add a grey border */
            margin-top: 12px;
            margin-bottom: 12px; /* Add some space below the input */
        }
    </style>
</head>
<body class="menu-body">
    <div class="menu-whole-page">
        <div class="menu-header">
            <div class="menu-header-left">
                <a><img src="images/vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
                <h1>BurgerBytes Menu</h1>
            </div>
            <a href="staffLogout.php" class="logout-button">Logout</a>
        </div>
        <div class="sidebar">
            <a href="manager.php">View Menu</a>
            <a href="additem.php">Add New Item</a>
            <a href="viewOrderHistory.php">View Orders</a>
            <a href="managestaff.php">Manage Staff</a>
            <a href="addstaff.php">Add Staff</a>
            <a href="ManagerOrder.php">View Orders</a>
        </div>

        <div class="order-history-container">
            <div class="filter-section">
                <form method="GET" action="">
                    <div>
                        
                        <input type="date" id="start_date" name="start_date">
                    
                        <input type="date" id="end_date" name="end_date">
                    </div>
                    <div>
                        <input type="text" id="myInput" placeholder="Search by Username" name="username">
                    </div>
                    <div class="apply-filters-btn">
                        <button type="submit">Apply Filters</button>
                    </div>
                </form>
            </div>

            <?php
            session_start();
            if (isset($_SESSION["staff"]) && $_SESSION["accesslevel"] === 'manager') {
                require_once("settings.php");
                $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
                if (!$dbconn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Initialize filter variables
                $start_date = $_GET['start_date'] ?? null;
                $end_date = $_GET['end_date'] ?? null;
                $username = $_GET['username'] ?? null;

                // Adjust end_date to include the entire day
                if ($end_date) {
                    $end_date .= ' 23:59:59';
                }

                // Build the SQL query
                $sql = "
                    SELECT o.order_id, o.user_id, o.orderdate, o.status, oi.order_id AS oi_order_id, oi.product_name, oi.product AS oi_product_id, c.username
                    FROM orders o
                    LEFT JOIN ordered_item oi ON o.order_id = oi.order_id
                    LEFT JOIN customers c ON o.user_id = c.user_id
                    WHERE o.status = 'COMPLETE'
                ";

                // Append date range conditions only if dates are provided
                if ($start_date && $end_date) {
                    $sql .= " AND o.orderdate BETWEEN '$start_date' AND '$end_date'";
                } elseif ($start_date) {
                    $sql .= " AND o.orderdate >= '$start_date'";
                } elseif ($end_date) {
                    $sql .= " AND o.orderdate <= '$end_date'";
                }

                // Append username search condition if provided
                if ($username) {
                    $sql .= " AND c.username LIKE '$username%'";
                }

                $sql .= " ORDER BY o.order_id, oi.product;";

                $result = mysqli_query($dbconn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $current_order_id = null;
                    echo "<table class='order-history-table' border='1'>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Username</th>
                                    <th>Order Date</th>
                                    <th>Items</th>
                                </tr>
                            <tbody>";
                
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($current_order_id != $row['order_id']) {
                            if ($current_order_id !== null) {
                                echo "</ul></td></tr>";
                            }
                            $current_order_id = $row['order_id'];
                            echo "<tr>
                                    <td>{$row['order_id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['orderdate']}</td>
                                    <td><ul>";
                        }
                        echo "<li>{$row['product_name']} (Item ID: {$row['oi_product_id']})</li>";
                    }
                    echo "</ul></td></tr>
                        </tbody>
                    </table>";
                } else {
                    echo "<p>No orders found.</p>";
                }
                
                mysqli_close($dbconn);
            } else {
                echo "<p>Please log in as manager to view this page.</p>";
            }
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
