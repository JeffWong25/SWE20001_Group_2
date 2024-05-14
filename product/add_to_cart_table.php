<tr>
    <td rowspan='3' class='product_div_img'>
        <img src='../<?php echo $row['imgpath']; ?>' alt='<?php echo $row['item_name']; ?>' style='width: 550px; height: auto;'>
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
    <td class='product_page_add' onclick='addToCart(this)' data-item-id='<?php echo $row['item_id']; ?>'>ADD</td>
</tr>
