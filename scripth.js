











// Función para inicio de sesión real
function loginUser(username, password) {
    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            localStorage.setItem('user', JSON.stringify(data.user));
            document.getElementById('authModal').style.display = 'none';
            document.getElementById('userInfo').style.display = 'flex';
            document.getElementById('displayUsername').textContent = data.user.username;
            alert('¡Bienvenido de nuevo, ' + data.user.username + '!');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Función para registro real
function registerUser(username, password) {
    fetch('register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Después de registrar, iniciar sesión automáticamente
            loginUser(username, password);
            alert('¡Cuenta creada con éxito! Bienvenido, ' + username + '.');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}