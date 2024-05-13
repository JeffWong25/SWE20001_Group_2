<!DOCTYPE html>
<html lang="en"></html>
<head class="bg"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Menu</title>
    <link rel="stylesheet" href="../styling/style.css">
    <link rel="stylesheet2" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
</head>
<body class="menu-body">
    <div class="menu-header">
        <a><img src="../images/vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
        <h1>BurgerBytes Products</h1>
    </div>
    <div class = "product_page">
        <?php
            //connect to database based on credentials in settings.php
            require_once("../settings.php");
            $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
            if (!$dbconn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT item_name, imgpath, `desc`, price FROM menu_items WHERE item_id = 1001";
                $result = mysqli_query($dbconn, $sql);

                echo "<table border = "1">";
                if ($row = mysqli_fetch_assoc($result)) {
                    
                    echo "<div class='product'>";
                    echo "<tr>"
                    echo "<div class = product_div_img>";
                    echo "<span class='product_img'><td rowspan="3"><img src='../" . $row['imgpath'] . "' alt='" . $row['item_name'] . "' style='width: 600px; height: auto;'></td></span><br>";
                    echo "</div>";

                    echo "<div class = product_div_desc>";
                    echo "<td colspan="2"><span class='product_name'><heavy>" . $row['item_name'] . "</heavy></span><br>";
                    echo "<span class='product_desc'>" . $row['desc'] . "</span><br></td>";
                    echo "</tr>";
                    echo "<tr><td colspan"2">";
                    echo "<form>";
                    echo "  <label for=\"textbox_id\">Enter your name:</label>";
                    echo "  <input type=\"text\" name=\"username\" id=\"textbox_id\">";
                    echo "</form>";
                    echo "<td></tr>";
                    
                    echo "<tr>";     
                    echo "<span class='product_price'><td>" . $row['price'] . "</td></span>";
                    echo "<td></td>"; 
                    echo "</tr>";
                    echo "</div>";

                    echo "</div>";
                } 
                echo"</table";

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

</html>