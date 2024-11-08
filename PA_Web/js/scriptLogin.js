document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const passwordField = toggle.previousElementSibling;
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggle.textContent = '🙈';
        } else {
            passwordField.type = 'password';
            toggle.textContent = '👁️';
        }
    });
});

// Simple form validation feedback
document.getElementById('loginForm').addEventListener('submit', function(event) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (!username || !password) {
        event.preventDefault(); // Prevent form submission
        alert('Please fill in all required fields.');
    }
});

