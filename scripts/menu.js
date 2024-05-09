"use strict";
function filterTable(categoryId) {
    var table, rows, i, categoryCell, categoryValue;
    table = document.getElementById("menuTable");
    rows = table.getElementsByTagName("tr");
    for (i = 1; i < rows.length; i++) {
        categoryCell = rows[i].getElementsByTagName("td")[5]; // Index 5 is the category ID column
        if (categoryCell) {
            categoryValue = categoryCell.textContent || categoryCell.innerText;
            if (parseInt(categoryValue) === categoryId) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
}