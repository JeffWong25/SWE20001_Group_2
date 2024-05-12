<!DOCTYPE html>
<html lang="en">
<div class ="menu-whole-page">
<head class="bg"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'?>
    <title>BurgerBytes Menu</title>
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
    <script src="scripts/menu.js"></script>
</head>
<body class="menu-body">
    <div class="menu-header">
        <a><img src="images\vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
        <h1>BurgerBytes Products</h1>
    </div>
    <div>
        <div class="menu-nav">
            <a href="#" onclick="filterTable(1)">Burgers</a>
            <a href="#" onclick="filterTable(2)">Side Dishes</a>
            <a href="#" onclick="filterTable(3)">Beverages</a>
            <a href="#" onclick="resetTable()">Show All</a>
        </div>
    <?php
        //connect to database based on credentials in settings.php
        require_once("settings.php");
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT item_id, item_name, imgpath, `desc`, price, category_id FROM menu_items";
        $result = mysqli_query($dbconn, $sql);

        //generate table
        echo "<table id='menu-table' class='menu-table' border='1'>";
        echo "<thead class='menu-table-head'>";
            echo "<tr>";
                echo "<th>Image</th>"; 
                echo "<th>Item ID</th>";
                echo "<th>Item Name</th>";
                echo "<th>Description</th>";
                echo "<th>Price</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row=mysqli_fetch_assoc($result)){
            echo "<tr data-category='" . $row['category_id'] . "'>";
            echo "<td rowspan='2'><img src='" . $row['imgpath'] . "'alt='" . $row['item_name'] . "'style='width: 90px; height: auto;'></td>"; // Display the image
            echo "<td>" . $row['item_id'] . "</td>";
            echo "<td>" . $row['item_name'] . "</td>";
            echo "<td>" . $row['desc'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
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