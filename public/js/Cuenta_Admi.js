// Función para abrir un modal específico por ID
function openModal(id) {
    document.getElementById(id).style.display = 'block';
}

// Función para cerrar un modal específico por ID
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

// Simula la actualización de nombre y correo (uso visual)
function updateData() {
    const newName = document.getElementById('newName').value;
    const newEmail = document.getElementById('newEmail').value;

    if (newName && newEmail) {
        // Refleja los cambios en el DOM (interfaz)
        document.getElementById('user-name').innerText = newName;
        document.getElementById('user-email').innerText = newEmail;
        closeModal('updateModal');
        alert('Datos actualizados correctamente.');
    } else {
        alert('Por favor completa ambos campos.');
    }
}

// Simula el cambio de contraseña con validación
function changePassword() {
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = document.getElementById('confirmPassword').value;

    if (newPass && confirmPass && newPass === confirmPass) {
        closeModal('passwordModal');
        alert('Contraseña actualizada correctamente.');
    } else {
        alert('Las contraseñas no coinciden o están vacías.');
    }
}

// Simula eliminación de cuenta (se espera que haya integración backend)
function deleteAccount() {
    closeModal('deleteModal');
    alert('Cuenta eliminada (simulado). Aquí iría una llamada al backend.');
    // Aquí podrías redirigir, eliminar sesión o enviar un request al backend
}

// Vista previa de la imagen de perfil seleccionada
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();

        // Cuando se carga la imagen
        reader.onload = function (e) {
            const profilePic = document.getElementById('profilePic');
            profilePic.src = e.target.result;

            // Oculta el ícono de cámara tras la carga
            const cameraIcon = document.querySelector('.camera-icon');
            if (cameraIcon) {
                cameraIcon.style.display = 'none';
            }
        };

        // Lee el archivo como URL de imagen para mostrarlo en pantalla
        reader.readAsDataURL(file);
    }
}
