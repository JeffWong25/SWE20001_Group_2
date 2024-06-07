function myFunction() {
    // Declare variables
    var input, filter, table, tr, span, i, j, txtValue;
    input = document.getElementById("myInput");
    filter = input.value;
    table = document.getElementById("menu-table");
    tr = table.getElementsByTagName("tr");

   // Loop through all table rows, and hide those who don't match the search query
   for (i = 0; i < tr.length; i++) {
    var match = false;
    span = tr[i].getElementsByTagName("span");
    // Check all table cells for a match
    for (j = 0; j < 2; j++) {
        if (span[j]) {
            txtValue = span[j].textContent || span[j].innerText;
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
