function filterTable(categoryId) {
    var table, rows, i, categoryValue;
    table = document.getElementByClass("menu-table");
    rows = table.getElementsByTagName("tr");
    for (i = 1; i < rows.length; i++) {
        categoryValue = rows[i].getAttribute("data-category");
        if (categoryValue === String(categoryId)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}