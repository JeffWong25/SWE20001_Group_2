document.getElementById('addManagerForm').addEventListener('submit', function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch('process_add_manager.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Staff member added successfully!');
            // Optionally, clear the form or redirect to another page
            document.getElementById('addManagerForm').reset();
        } else {
            alert('Failed to add staff member: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
