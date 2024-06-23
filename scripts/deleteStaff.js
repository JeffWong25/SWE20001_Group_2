let staffIdsToDelete = [];

function deleteStaff() {
    staffIdsToDelete = [];
    const checkboxes = document.querySelectorAll('input[name="staffid[]"]:checked');
    checkboxes.forEach(checkbox => {
        staffIdsToDelete.push(checkbox.value);
    });

    if (staffIdsToDelete.length > 0) {
        var modal = document.getElementById("confirmationModal");
        modal.style.display = "block";
    } else {
        // Display a different modal for informing the user to select at least one staff member
        var selectModal = document.getElementById("selectModal");
        selectModal.style.display = "block";
    }
}

function confirmDelete() {
    var modal = document.getElementById("confirmationModal");
    modal.style.display = "none";
    if (staffIdsToDelete.length > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "deletestaff.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    staffIdsToDelete.forEach(staffId => {
                        var staffRow = document.getElementById("staff-" + staffId);
                        if (staffRow) {
                            staffRow.parentNode.removeChild(staffRow);
                        }
                    });
                } else {
                    alert(response.message);
                }
                staffIdsToDelete = [];
            }
        };
        xhr.send("staffids=" + JSON.stringify(staffIdsToDelete));
    }
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
    staffIdsToDelete = [];
}

window.onclick = function (event) {
    var confirmationModal = document.getElementById("confirmationModal");
    var selectModal = document.getElementById("selectModal");

    if (event.target == confirmationModal) {
        closeModal("confirmationModal");
    }
    if (event.target == selectModal) {
        closeModal("selectModal");
    }
};
