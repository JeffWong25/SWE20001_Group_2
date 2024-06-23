<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Manager Menu</title>
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <a href="viewOrderHistory.php">Order History</a>
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
                        <input type="text" id="myInput" placeholder="Search Username" name="username">
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

                // Initialize pagination variables
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
                $limit = 5; // Orders limit per page to be displayed 
                $start_limit = ($page - 1) * $limit;

                // Initialize filter variables
                $start_date = $_GET['start_date'] ?? null;
                $end_date = $_GET['end_date'] ?? null;
                $username = $_GET['username'] ?? null;

                // Adjust end_date to include the entire day
                if ($end_date) {
                    $end_date .= ' 23:59:59';
                }

                // SQL query without LIMIT clause for counting total rows
                $count_query = "
                SELECT COUNT(*) AS total_orders
                FROM orders o
                LEFT JOIN customers c ON o.user_id = c.user_id
                WHERE o.status = 'COMPLETE'
            ";

                // Append date range conditions only if dates are provided
                if ($start_date && $end_date) {
                    $count_query .= " AND o.orderdate BETWEEN '$start_date' AND '$end_date'";
                } elseif ($start_date) {
                    $count_query .= " AND o.orderdate >= '$start_date'";
                } elseif ($end_date) {
                    $count_query .= " AND o.orderdate <= '$end_date'";
                }

                // Append username search condition if provided
                if ($username) {
                    $count_query .= " AND c.username LIKE '$username%'";
                }

                $count_result = mysqli_query($dbconn, $count_query);
                $row = mysqli_fetch_assoc($count_result);
                $total_orders = $row['total_orders'];

                // Calculate number of pages
                $total_pages = ceil($total_orders / $limit);

                // Build the SQL query with LIMIT clause for pagination
                $sql = "
                    SELECT o.order_id, o.user_id, o.orderdate, o.status, c.username
                    FROM orders o   
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

                $sql .= " ORDER BY o.order_id
                          LIMIT $start_limit, $limit;"; // Limit orders per page


                $result = mysqli_query($dbconn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    echo "<table class='order-history-table' border='1'>
                            <tr>
                                <th>Order ID</th>
                                <th>Username</th>
                                <th>Order Date</th>
                                <th>Items</th>
                            </tr>
                          <tbody>";
                
                    $current_order_id = null;
                
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($current_order_id !== $row['order_id']) {
                            // Close previous order's list if exists
                            if ($current_order_id !== null) {
                                echo "</ul></td></tr>";
                            }
                            // Start a new row for each distinct order
                            $current_order_id = $row['order_id'];
                            echo "<tr>
                                    <td>{$row['order_id']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['orderdate']}</td>
                                    <td><ul>";
                            
                            // Query to fetch ordered items for the current order
                            $order_id = $row['order_id'];
                            $items_query = "SELECT product_name, product AS oi_product_id 
                                            FROM ordered_item 
                                            WHERE order_id = $order_id";
                            $items_result = mysqli_query($dbconn, $items_query);
                
                            // Display each item within the order
                            while ($item_row = mysqli_fetch_assoc($items_result)) {
                                echo "<li>{$item_row['product_name']} (Item ID: {$item_row['oi_product_id']})</li>";
                            }
                        }
                
                        // list will be closed when a new order starts, no need to close here
                    }
                
                    // Close the last order's list
                    if ($current_order_id !== null) {
                        echo "</ul></td></tr>";
                    }
                
                    echo "</tbody></table>";
                
                    // Pagination logic with page numbers
                    echo "<div class='pagination'>";
                    if ($page > 1) {
                        echo "<a href='?page=" . ($page - 1) . "&start_date=$start_date&end_date=$end_date&username=$username'>Previous</a>";
                    }
                
                    // Determine start and end of page numbers to display
                    $start_page = max(1, $page - 1);
                    $end_page = min($total_pages, $page + 1);
                
                    // Display page numbers
                    for ($i = $start_page; $i <= $end_page; $i++) {
                        $active_class = ($i == $page) ? 'active' : '';
                        echo "<a class='$active_class' href='?page=$i&start_date=$start_date&end_date=$end_date&username=$username'>$i</a>";
                    }
                
                    if ($page < $total_pages) {
                        echo "<a href='?page=" . ($page + 1) . "&start_date=$start_date&end_date=$end_date&username=$username'>Next</a>";
                    }
                    echo "</div>";
                
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
