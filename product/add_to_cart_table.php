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

<tr>
    <td rowspan='3' class='product_div_img'>
        <img src='../<?php echo $row['imgpath']; ?>' alt='<?php echo $row['item_name']; ?>' style='width: 550px; height: auto; max-width: 550px; max-height: 550px;'>
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
