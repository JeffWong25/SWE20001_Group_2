let itemIdToDelete = null;

function deleteItem(itemId) {
    itemIdToDelete = itemId;
    var modal = document.getElementById("confirmationModal");
    modal.style.display = "block";
}

function confirmDelete() {
    var modal = document.getElementById("confirmationModal");
    modal.style.display = "none";
    if (itemIdToDelete !== null) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "delete_menu_item.php?item_id=" + itemIdToDelete, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    var itemRow = document.getElementById("item-" + itemIdToDelete);
                    if (itemRow) {
                        itemRow.parentNode.removeChild(itemRow);
                    }
                } else {
                    alert(response.message);
                }
            }
        };
        xhr.send();
    }
}

function closeModal() {
    var modal = document.getElementById("confirmationModal");
    modal.style.display = "none";
    itemIdToDelete = null;
}

window.onclick = function (event) {
    var modal = document.getElementById("confirmationModal");
    if (event.target == modal) {
        closeModal();
    }
};
