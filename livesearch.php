<?php
   session_start();
   //if(isset($_SESSION["manager"])){
       require_once("settings.php");
       $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
       if (!$dbconn) {
           die("Connection failed: " . mysqli_connect_error());
       }

    //    $sql = "SELECT *  FROM staff
    //    WHERE staffid = '{$_SESSION["manager"]}'";

    //    $result = mysqli_query($dbconn, $sql);
    //    $customer = $result->fetch_assoc();

       if(isset($_POST['input'])){
        $input = $_POST['input'];
        $query = "SELECT * FROM menu_items WHERE item_name LIKE '{$input}%' LIMIT 5";
        $result1 = mysqli_query($dbconn, $query);

        if(mysqli_num_rows($result1) > 0){?>
            <table class="table rable-bordered table-struped mt-4">
                <thread>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                </thread>
                <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result1)){
                    $id = $row['item_id'];
                    $name = $row['item_name'];
                    $image = $row['imgpath'];
                    $desc = $row['desc'];
                    $price = $row['price'];
                }
                ?>

                <tr>
                    <td><?php echo $id;?></td>
                    <td><?php echo $name;?></td>
                    <td><?php echo $image;?></td>
                    <td><?php echo $desc;?></td>
                    <td><?php echo $price;?></td>
                </tr>
                </tbody>
            </table>





            <?php
        }else{
            echo"<h6 class ='text-danger text-center mt-3'>No data found</h6>";
        }
       }
   //}
?>
