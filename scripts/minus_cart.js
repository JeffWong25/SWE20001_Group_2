function minusCart(element) {
    const cart_id = element.getAttribute('data-item-id');
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'minus_from_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText === 'success') {
                // Reload the page
                location.reload();
            } else {
                alert('An error occurred while removing the item from the cart.');
            }
        }
    };
    xhr.send('cart_id=' + cart_id);
    }
