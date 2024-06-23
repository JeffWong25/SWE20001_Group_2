function myFunction() {
    // Declare variables
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toLowerCase().trim();
    table = document.getElementById("menu-table");
    tr = table.getElementsByTagName("tr");

   // Loop through all table rows, and hide those who don't match the search query
   for (i = 0; i < tr.length; i++) {
        var match = false;

        var itemId = tr[i].querySelector('.item-id');
        var itemName = tr[i].querySelector('.item-name');
        var itemPrice = tr[i].querySelector('.item-price');
        td = tr[i].getElementsByTagName("td");

        if (itemId) {
            txtValue = itemId.textContent || itemId.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                match = true;
            }
        }
        if (itemName && !match) {
            txtValue = itemName.textContent || itemName.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                match = true;
            }
        }
        if (itemPrice && !match) {
            txtValue = itemPrice.textContent || itemPrice.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                match = true;
            }
        }
        tr[i].style.display = match ? "" : "none";
        // Check all table cells for a match
        /*for (j = 0; j < 3; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                txtValue = txtValue.toLowerCase().trim();
                if (txtValue.indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
        }
        if (match) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }*/
    }
}
