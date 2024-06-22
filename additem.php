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
        <a href="viewOrderHistory.php">Order History</a>
        <a href="managestaff.php">Manage Staff</a>
        <a href="addstaff.php">Add Staff</a>
        <a href="ManagerOrder.php">View Orders</a>
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

        if (isset($_FILES['imgpath']) && $_FILES['imgpath']['error'] == 0) {
            $imgpath = $_FILES['imgpath'];
            // Handle image upload
            $target_dir = "images/";
            $target_file = $target_dir . basename($imgpath["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Check if file is an image
            $check = getimagesize($imgpath["tmp_name"]);
            if($check === false) {
                die("<div class='error-message'>File is not an image <a href='additem.php'>Readd item</a></div>");
            }
            // Check file size (5MB max)
            if ($imgpath["size"] > 5000000) {
                die("<div class='error-message'>Image is too large, maximum size is 5MB <a href='additem.php'>Readd item</a></div>");
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                die("<div class='error-message'>Only JPG, JPEG, PNG & GIF files are allowed <a href='additem.php'>Readd item</a></div>");
            }
            // Move file to target directory
            if (!move_uploaded_file($imgpath["tmp_name"], $target_file)) {
                die("<div class='error-message'>An error occured while uploading your file <a href='additem.php'>Readd item</a></div>");
            }

            //concatenate
            $imgpath = "images/" . basename($imgpath["name"]);
        }else {
            die("<div class='error-message'>No file was uploaded or there was an upload error: " . [$error_code] . "</div>");
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
            createProductPage($next_id, $item_name, $desc, $price, $imgpath);
        } else {
            echo "<div class='error-message'>Error: " . $sql . "<br>" . mysqli_error($dbconn) . "</div>";
        }
        mysqli_close($dbconn);
        exit();
    }

    function createProductPage($item_id, $item_name, $desc, $price, $imgpath) {
    $page_content = <<<EOD
    <!DOCTYPE html>
    <html lang="en">
    <head class="bg"> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BurgerBytes Product</title>
        <link rel="stylesheet" href="../styling/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
        <script>
        function addToCart(element) {
            const itemId = element.getAttribute('data-item-id');
            const preference = document.getElementById('textbox_id').value;
            const cust_gmail = element.getAttribute('data-gmail');
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_to_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText); // Display response from server
                window.location.href = '../menu.php';
            }
        };
        xhr.send('item_id=' + itemId + '&preference=' + encodeURIComponent(preference) + '&customer_email=' + encodeURIComponent(cust_gmail));
    }

    // Event listener for product_page_add elements
    const addToCartButtons = document.querySelectorAll('.product_page_add');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
                window.location.href = '../menu.php'; // Redirect to menu.php
            });
        });
    </script>
    </head>
    <body class="menu-body">
        <div class="menu-header">
            <a href="#"><img src="../images/vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
            <h1>BurgerBytes Products</h1>
        </div>
        <div class="product_page">
            <?php
            session_start();
            if (isset(\$_SESSION["customer"])) {
                require_once("../settings.php");
                \$dbconn = @mysqli_connect(\$host, \$user, \$pwd, \$sql_db);
                if (!\$dbconn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                \$sql = "SELECT email FROM customers WHERE user_id = '{\$_SESSION["customer"]}'";
                \$result = mysqli_query(\$dbconn, \$sql);
                \$customer = mysqli_fetch_assoc(\$result);

                if (\$customer) {
                    \$customer_email = \$customer["email"];
                } else {
                    \$customer_email = "Email not found";
                }

                mysqli_close(\$dbconn);
            } else {
                \$customer_email = "No customer logged in";
            }

            require_once("../settings.php");
            \$dbconn = @mysqli_connect(\$host, \$user, \$pwd, \$sql_db);
            if (!\$dbconn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            \$sql = "SELECT item_name, imgpath, `desc`, price, item_id FROM menu_items WHERE item_id = $item_id";
            \$result = mysqli_query(\$dbconn, \$sql);

            echo "<table style='margin: 20px;'>";
            if (\$row = mysqli_fetch_assoc(\$result)) {
                // Pass customer email to add_to_cart_table.php
                \$row['customer_email'] = \$customer_email;
                require("add_to_cart_table.php");
            }
            echo "</table>";
        ?>
        </div>
        <?php require("footer.php"); ?>
    </body>
    </html>
    EOD;

        $file_path = "product/$item_id.php";
        file_put_contents($file_path, $page_content);
    }
    ?>
    <div class="add-item-form" id="add-item-form">
        <form method="POST" action="" enctype="multipart/form-data">
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
                <input type="text" id="price" name="price" pattern="\d+(\.\d{1,2})?" title="Please enter a valid decimal number" 1000?required><br>
                <label for="imgpath">Image:</label>
                <input type="file" id="imgpath" name="imgpath" accept="image/*" required><br>
                <br>
                <button type="submit">Add Item</button>
                <button class="canceladd-button" onclick="window.location.href='manager.php';">Cancel</button>
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