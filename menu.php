<!DOCTYPE html>
<html lang="en">
<head class="bg"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'?>
    <title>BurgerBytes Menu</title>
    <link rel="stylesheet" href="styling/style.css">
    <script src="scripts/menu.js"></script>
</head>
<body class="menu-body">
    <h1>BurgerBytes Products</h1>
    <div>
        <div class="menu-nav">
            <a href="#" onclick="filterTable(1)">Category 1</a>
            <a href="#" onclick="filterTable(2)">Category 2</a>
            <a href="#" onclick="filterTable(3)">Category 3</a>
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
        echo "<table class='menuTable' border='1'>";
        echo "<thead>";
            echo "<tr>";
                echo "<th>Item ID</th>";
                echo "<th>Item Name</th>";
                echo "<th>Image</th>"; 
                echo "<th>Description</th>";
                echo "<th>Price</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row=mysqli_fetch_assoc($result)){
            echo "<tr data-category='" . $row['category_id'] . "'>";
            echo "<td>" . $row['item_id'] . "</td>";
            echo "<td>" . $row['item_name'] . "</td>";
            echo "<td><img src='" . $row['imgpath'] . "'alt='" . $row['item_name'] . "'style='width: 90px; height: auto;'></td>"; // Display the image
            echo "<td>" . $row['desc'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";    
        echo "</table>";
        mysqli_close($dbconn);
    ?>  
    </div>
</body>
</html>