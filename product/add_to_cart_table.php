<style>
.product_page_add {
    width: 25%;
    font-size: 23px;
    font-weight: bold;
    background: linear-gradient(45deg, #F81B15, #FDC400);
    color: #fff;
    padding: 8px;
    border: none;
    margin: 10px 0;
    border-radius: 100px;
    cursor: pointer;
    text-align: center;
    transition: 0.2s;
}

.product_page_add:active {
    transform: scale(0.9);
}
</style>

<?php
    if (isset($_SESSION["customer"])) {
        require_once("../settings.php");
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT email FROM customers WHERE user_id = '{$_SESSION["customer"]}'";
        $result = mysqli_query($dbconn, $sql);
        $customer = mysqli_fetch_assoc($result);

        if ($customer) {
            $customer_email = $customer["email"];
        } else {
            $customer_email = "Email not found";
        }

        mysqli_close($dbconn);
    } else {
        $customer_email = "No customer logged in";
    }
?>

<tr>
    <td rowspan='3' class='product_div_img'>
        <img src='../<?php echo $row['imgpath']; ?>' alt='<?php echo $row['item_name']; ?>' style='width: 500px; height: auto; max-width: 500px; max-height: 500px;'>
    </td>
    <td colspan='2' class='product_div_desc' style='vertical-align: top; padding-left: 12px; padding-right: 12px;'>
        <span class='product_name'><strong><h1><?php echo $row['item_name']; ?></h1></strong></span><br>
        <span class='product_desc' style='font-size: 19px;'><?php echo $row['desc']; ?></span><br>
    </td>
</tr>
<tr>
    <td colspan='2' style='padding-left: 12px;'>
        <form>
            <div style='margin-bottom: 10px;'>
                <label for='textbox_id' style='display: block; margin-bottom: 5px;'>Preference(Optional):</label>
                <textarea name='preference' id='textbox_id' class='enlarge-textarea'></textarea>
            </div>
        </form>
    </td>
</tr>
<tr>
    <td class='product_price'><strong>RM<?php echo $row['price']; ?></strong></td>
    <td class='product_page_add' onclick='addToCart(this)' data-item-id='<?php echo $row['item_id']; ?>' data-gmail='<?php echo $customer_email; ?>'>ADD</td>
</tr>
