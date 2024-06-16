<!DOCTYPE html>
<html lang="en">
<head class="bg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BurgerBytes Add Staff</title>
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="menu-body">
    <div class="menu-header">
        <div class="menu-header-left">
            <a><img src="images/vecteezy_burger-vector-logo-template-in-line-style-burger-simple-icon_7714606.png" id="logo" alt="BurgerBytes logo" width="80"></a>
            <h1>BurgerBytes Add Staff</h1>
        </div>
        <a href="staffLogout.php" class="logout-button">Logout</a>
    </div>
    <div class="sidebar">
    <div class="sidebar">
        <a href="manager.php">View Menu</a>
        <a href="additem.php">Add New Item</a>
        <a href="viewOrderHistory.php">View Orders</a>
        <a href="managestaff.php">Manage Staff</a>
        <a href="addstaff.php">Add Staff</a>
        <a href="ManagerOrder.php">View Orders</a>
    </div>
    </div>
    <h2><center>Add New Staff Member</center></h2>
        <form id="addManagerForm" class="add-staff-form" method="POST" action="process_add_staff.php">
            <label for="staffid">Staff ID:</label><br>
            <input type="text" id="staffid" name="staffid" required><br>
            <label for="fname">First Name:</label><br>
            <input type="text" id="fname" name="fname" required><br>
            <label for="lname">Last Name:</label><br>
            <input type="text" id="lname" name="lname" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="role">Role:</label><br>
            <select id="role" name="role" required>
                <option value="manager">Manager</option>
                <option value="cashier">Cashier</option>
                <option value="kitchen">Kitchen</option>
            </select><br>
            <button type="submit">Add Staff</button>
        </form>
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
