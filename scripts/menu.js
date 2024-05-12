function filterTable(categoryId) {
    var table, rows, i, categoryValue;
    table = document.getElementById("menu-table");
    rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        categoryValue = rows[i].getAttribute("data-category");
        if (categoryValue === String(categoryId)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function resetTable() {
    var table, rows, i;
    table = document.getElementById("menu-table");
    rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        rows[i].style.display = ""; // Reset display of all rows
    }
}