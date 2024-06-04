<!DOCTYPE html>
<html lang="en">
<head class="bg"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Menu</title>
    <link rel="stylesheet" href="../styling/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
</head>
<body class="menu-body">
    <div class="menu-header">
        <a href="#"><img src="../images/vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
        <h1>Edit Product</h1>
    </div>
     <?php
            require_once("settings.php");
            $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
            if (!$dbconn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Check if form was submitted to update an item
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $item_id = $_POST['item_id'];
                $item_name = $_POST['item_name'];
                $desc = $_POST['desc'];
                $price = $_POST['price'];
                $imgpath = $_POST['imgpath'];
                $update_sql = "UPDATE menu_items SET item_name = '$item_name', `desc` = '$desc', price = '$price', imgpath = '$imgpath' WHERE item_id = '$item_id'";
            if (mysqli_query($dbconn, $update_sql)) {
                    header("Location: manager_menu.php");
                    exit;
                } else {
                    echo "<p class='error-message'>Error updating item: " . mysqli_error($dbconn) . "</p>";
                }
            }

            if (isset($_GET['item_id'])) {
                $item_id = $_GET['item_id'];
                $sql = "SELECT item_id, item_name, imgpath, `desc`, price FROM menu_items WHERE item_id = '$item_id'";
                $result = mysqli_query($dbconn, $sql);
                if (!$result) {
                    die("Error fetching item: " . mysqli_error($dbconn));
                }
                $item = mysqli_fetch_assoc($result);
                if (!$item) {
                    die("No item found with ID $item_id");
                }
            } else {
                die("No item ID provided");
            }
        ?>
    <div class="edit_product_page">
         <form id="edit-form" method="POST">
            <h2>Edit Menu Item</h2>
            <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
            <label for="edit-item-name">Item Name:</label>
            <input type="text" id="edit-item-name" name="item_name" value="<?php echo $item['item_name']; ?>" required><br>
            <label for="edit-desc">Description:</label>
            <textarea id="edit-desc" name="desc" required><?php echo $item['desc']; ?></textarea><br>
            <label for="edit-price">Price:</label>
            <input type="text" id="edit-price" name="price" value="<?php echo $item['price']; ?>" required><br>
            <label for="edit-imgpath">Image Path:</label>
            <input type="text" id="edit-imgpath" name="imgpath" value="<?php echo $item['imgpath']; ?>" required><br>
            <button type="submit">Update</button>
            <a href="manager_menu.php">Cancel</a>
        </form> 
    </div>
    <?php require("footer.php"); ?>
</body>
</html>