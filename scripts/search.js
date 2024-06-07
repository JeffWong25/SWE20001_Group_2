function myFunction() {
    // Declare variables
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value;
    table = document.getElementById("menu-table");
    tr = table.getElementsByTagName("tr");

   // Loop through all table rows, and hide those who don't match the search query
   for (i = 0; i < tr.length; i++) {
    var match = false;
    td = tr[i].getElementsByTagName("td");
    // Check all table cells for a match
    for (j = 0; j < td.length; j++) {
        if (td[j]) {
            txtValue = td[j].textContent || td[j].innerText;
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
    }
}
  }
