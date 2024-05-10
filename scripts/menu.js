document.addEventListener("DOMContentLoaded", function() {
    // Code inside this function will run after the DOM content is loaded
    function filterTable(categoryId) {
        var table, rows, i, categoryValue;
        table = document.getElementById("menu-table");
        if (table) { // Check if table exists
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
    }
});