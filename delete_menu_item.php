<!DOCTYPE html>
<html lang="en">
<div class ="menu-whole-page">
<head class="bg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Manager Menu</title>
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="menu-body">
    <div class="menu-header">
        <div class="menu-header-left">
            <a><img src="images\vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
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
    <?php
    session_start();
    if (isset($_SESSION["staff"]) && $_SESSION["accesslevel"] === 'manager') { 
        if (isset($_GET['item_id'])) {
            $item_id = $_GET['item_id'];
            require_once("settings.php");
            $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
            if (!$dbconn) {
                echo json_encode(array('status' => 'error', 'message' => 'Connection failed: ' . mysqli_connect_error()));
                exit();
            }
            $sql = "DELETE FROM menu_items WHERE item_id = ?";
            $stmt = $dbconn->prepare($sql);
            $stmt->bind_param("i", $item_id);
            if ($stmt->execute()) {
                $file_path = __DIR__ . "\\product\\{$item_id}.php";
                if (file_exists($file_path)) {
                    if (unlink($file_path)) {
                        echo json_encode(array('status' => 'success', 'message' => 'Item and corresponding page deleted successfully'));
                    } else {
                        echo json_encode(array('status' => 'error', 'message' => 'Item deleted but failed to delete the corresponding page'));
                    }
                }echo json_encode(array('status' => 'success', 'message' => 'Item deleted successfully (no corresponding page found)'));      
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Failed to delete item'));
            }
            $stmt->close();
            mysqli_close($dbconn);
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid item ID'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Unauthorized'));
    }
    ?>
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
</div>
</html>
