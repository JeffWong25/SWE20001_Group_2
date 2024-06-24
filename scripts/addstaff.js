function validateForm() {
    var fname = document.getElementById('fname').value.trim();
    var lname = document.getElementById('lname').value.trim();
    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value.trim();
    var role = document.getElementById('role').value.trim();

    if (fname === '' || lname === '' || email === '' || password === '' || role === '') {
        alert('Please fill in all fields');
        return false;
    }

    // You can add more specific validation if needed (e.g., email format check)
    return true;
}
