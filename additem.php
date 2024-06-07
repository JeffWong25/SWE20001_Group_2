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
    require_once("settings.php");
    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$dbconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $category = $_POST['category'];
        $item_name = $_POST['item_name'];
        $desc = $_POST['desc'];
        $price = $_POST['price'];
        $imgpath = $_POST['imgpath'];

        // Validate price
        if (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
        die("Invalid price format");
        }

        // Handle image upload
        $target_dir = "images/";
        $target_file = $target_dir . basename($imgpath["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($imgpath["tmp_name"]);
        if($check === false) {
        die("File is not an image");
        }

        // Check file size (5MB max)
        if ($imgpath["size"] > 5000000) {
            die("Image is too large, maximum size is 5MB");
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            die("Only JPG, JPEG, PNG & GIF files are allowed");
        }

        // Move file to target directory
        if (!move_uploaded_file($imgpath["tmp_name"], $target_file)) {
            die("Sorry, there was an error uploading your file");
        }

        // Determine the starting ID based on category
        switch ($category) {
            case 'burger':
                $start_id = 1000;
                $category_id = 1;
                break;
            case 'side_dish':
                $start_id = 2000;
                $category_id = 2;
                break;
            case 'beverage':
                $start_id = 3000;
                $category_id = 3;
                break;
        }

        // Get the next available ID for the category
        $sql = "SELECT MAX(item_id) AS max_id FROM menu_items WHERE item_id >= $start_id AND item_id < $start_id + 1000";
        $result = mysqli_query($dbconn, $sql);
        $row = mysqli_fetch_assoc($result);
        $next_id = $row['max_id'] ? $row['max_id'] + 1 : $start_id;

        // Insert the new item into the database
        $sql = "INSERT INTO menu_items (item_id, item_name, `desc`, price, imgpath, category_id, add_button, edit_button, delete_button) VALUES ('$next_id', '$item_name', '$desc', '$price', '$imgpath', '$category_id', 'images/add.png', 'images/edit.png', 'images/delete.png') ";
        if (mysqli_query($dbconn, $sql)) {
            echo "<div class='success-message'>New item added successfully. <a href='additem.php'>Add another item</a></div>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($dbconn);
        }
        mysqli_close($dbconn);
        exit();
    }
    ?>
    <div class="add-item-form" id="add-item-form">
        <form method="POST" action="">
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
                <input type="file" id="imgpath" name="imgpath" accept="image/*" required><br>
                <br>
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