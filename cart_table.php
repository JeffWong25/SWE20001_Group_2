<tr>
    <td><strong><?php echo $row['item_name']; ?></strong></td>
    <td><img src='<?php echo $row['imgpath']; ?>' alt='<?php echo $row['item_name']; ?>' style='width: 100px; height: 100px; max-width: 100px; max-height: 100px;'></td>
    <td class='desc-column'><?php echo $row['desc']; ?></td>
    <td class='comment-column'><?php echo $row['comment']; ?></td>
    <td class='minus_button' onclick='minusCart(this)' data-item-id='<?php echo $row['cart_id']; ?>'><img src='images/minus.png' alt='MINUS'></td>
</tr>
