document.addEventListener('DOMContentLoaded', () => {
    // Registro de usuario
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir el envío por defecto

            const formData = new FormData(this);
            formData.append('action', 'register'); // Añadir acción

            fetch('auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la red');
                }
                return response.text(); // O .json() si esperas un JSON
            })
            .then(data => {
                // Manejar la respuesta del servidor
                if (data.includes('Error:')) {
                    // Si hay un error en la respuesta, mostrarlo
                    alert(data);
                } else {
                    // Si el registro es exitoso, redirigir a la página de login
                    window.location.href = 'login.html';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un problema con la solicitud. Inténtalo de nuevo.');
            });
        });
    }
});

