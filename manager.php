<!DOCTYPE html>
<html lang="en">
<div class ="menu-whole-page">
<head class="bg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Manager Menu</title>
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="scripts/menu.js"></script>
    <script src="scripts/search.js"></script>
</head>
<body class="menu-body">
    <div class="menu-header">
        <div class="menu-header-left">
            <a><img src="images\vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
            <h1>BurgerBytes Menu</h1>
        </div>
         <!-- To whoever is making the manager login stuff, change this href to the actual staff login interface -->
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
    <div class="sidebar">
        <a href="manager.php">View Menu</a>
        <a href="additem.php">Add New Item</a>
        <a href="orders.php">View Orders</a>
    </div>
    <?php
    session_start();
    if(isset($_SESSION["manager"])){
        require_once("settings.php");
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT *  FROM staff
        WHERE staffid = '{$_SESSION["manager"]}'";

        $result = mysqli_query($dbconn, $sql);
        $customer = $result->fetch_assoc();
    }
    ?>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for id, names, price.....">
    <div class="menu-container">
    <?php
        //connect to database based on credentials in settings.php
        require_once("settings.php");
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT item_id, item_name, imgpath, `desc`, price, category_id, edit_button, delete_button FROM menu_items";
        $result = mysqli_query($dbconn, $sql);
        //generate table
        echo "<table id='menu-table' class='menu-table' border='1'>";
        echo "<thead class='menu-table-head'>";
        echo "</thead>";
        echo "<tbody>";
        while ($row=mysqli_fetch_assoc($result)){
            echo "<tr data-category='" . $row['category_id'] . "'>";
            echo "<td><img src='" . $row['imgpath'] . "'alt='" . $row['item_name'] . "'style='width: 150px; height: auto;'></td>"; // Display the image
            echo "<td>";
            echo "<span class='item-id'>" . $row['item_id'] . ".</span> "; // Apply style to item ID
            echo "<span class='item-name'>" . $row['item_name'] . "</span><br>"; // Apply style to item name
            echo "<span><strong class='item-price'>RM" . $row['price'] . "</strong></span><br>"; // Apply style to price
            echo "<span class='item-desc'>" . $row['desc'] . "</span><br>"; // Apply style to item description      
            echo "<a href='edit_item.php?item_id=" . $row['item_id'] . "'><img src='" . $row['edit_button'] . "' alt='EDIT' style='width: 30px; height: 30px;'></a>"; // Apply edit item
            echo "<a href='delete_item.php?item_id=" . $row['item_id'] . "'><img src='" . $row['delete_button'] . "' alt='DELETE' style='width: 30px; height: 30px;'></a>"; // Apply delete item
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        mysqli_close($dbconn);
    ?>
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
</div>
</html>
