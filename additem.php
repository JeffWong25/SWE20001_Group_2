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
    <div class="add-item-form" id="add-item-form">
        <form method="POST" action="add_item.php">
            <h2>Add New Item</h2>
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="burger">Burger</option>
                <option value="side_dish">Side Dish</option>
                <option value="beverage">Beverage</option>
            </select><br>
                <label for="item-name">Item Name:</label>
                <input type="text" id="item-name" name="item_name" required><br>
                <label for="desc">Description:</label>
                <textarea id="desc" name="desc" required></textarea><br>
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" required><br>
                <label for="imgpath">Image Path:</label>
                <input type="text" id="imgpath" name="imgpath" required><br>
                <button type="submit">Add Item</button>
            </form>
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