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
    <script src="scripts/search_staff.js"></script>
    <script src="scripts/delete_menu_item.js"></script>
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
        <a href="viewOrderHistory.php">View Orders</a>
        <a href="managestaff.php">Manage Staff</a>
        <a href="addstaff.php">Add Staff</a>
        <a href="ManagerOrder.php">View Orders</a>
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
    <input type="text" id="myInput" onkeyup="searchStaff()" placeholder="Search for ID, name, or role">
    <div class="add-staff-button-container">
            <button onclick="location.href='addStaff.php'" class="add-staff-button">Add New Staff</button>
        </div>
    <div class="menu-container">
    <?php
        //connect to database based on credentials in settings.php
        require_once("settings.php");
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT staffid, fname, lname, email, access_level FROM staff";
        $result = mysqli_query($dbconn, $sql);
        echo "<table id='menu-table' class='menu-table' border='1'>";
        echo "<thead class='menu-table-head'>";
        echo "</thead>";
        echo "<tbody>";
        echo"<tr>";
        echo "<td> Staff ID </td> ";
        echo "<td> First Name </td> ";
        echo "<td> Last Name </td> ";
        echo "<td> Email </td> ";
        echo "<td> Role </td> ";
        echo"</tr>";
        while ($row=mysqli_fetch_assoc($result)){

            echo"<tr>";
            echo "<td>" . $row['staffid'] . "</td> ";
            echo "<td>". $row['fname'] . "</td> ";
            echo "<td>" . $row['lname'] ."</td> ";
            echo "<td>" . $row['email'] . "</td> ";
            echo "<td>" . $row['access_level'] . "</td> ";
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

     <!-- The Modal -->
     <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <p>Are you sure you want to delete this staff member?</p>
            <button id="confirmDelete" class="confirm-button" onclick="deleteStaff()">Confirm</button>
            <button id="cancelDelete" class="cancel-button" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</body>
</div>
</html>