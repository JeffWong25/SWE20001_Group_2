<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>BurgerBytes Menu</title>
    <script src="menu.js"></script>
</head>
<body class="index1">
    <h1>Products</h1>
    <div class="header1">
        <div class="navigation">
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
        echo "<table id='menuTable' border='1'>";
        echo "<thead>";
            echo "<tr>";
                echo "<th>Item ID</th>";
                echo "<th>Item Name</th>";
                echo "<th>Image</th>"; 
                echo "<th>Description</th>";
                echo "<th>Price</th>";
                echo "<th>Category ID</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row=mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>" . $row['item_id'] . "</td>";
            echo "<td>" . $row['item_name'] . "</td>";
            echo "<td><img src='" . $row['imgpath'] . "'alt='" . $row['item_name'] . "'style='width: 90px; height: auto;'></td>"; // Display the image
            echo "<td>" . $row['desc'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['category_id'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";    
        echo "</table>";
        mysqli_close($dbconn);
    ?>  
    </div>
</body>
</html>