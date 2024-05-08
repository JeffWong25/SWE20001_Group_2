<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>BurgerBytes Menu</title>
</head>
<body class="index1">
    <h1>Products</h1>
    <div class="header1">
    <?php
        //connect to database based on credentials in settings.php
        require_once("settings.php");
        $dbconn = @mysqli_connect("localhost", "username", "password", "database");
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT item_id, item_name, imgpath, `desc`, price FROM menu_items";
        $result = mysqli_query($dbconn, $sql);

        //generate table
        echo "<table id='menuTable' border='1'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Item ID</th>";
        echo "<th'>Item Name</th>";
        echo "<th>Image</th>"; 
        echo "<th'>Description</th>";
        echo "<th'>Price</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row=mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>" . $row['item_id'] . "</td>";
                echo "<td>" . $row['item_name'] . "</td>";
                echo "<td><img src='" . $row['imgpath'] . "' alt='" . $row['item_name'] . "' style='width: 100px; height: auto;'></td>"; // Display the image
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