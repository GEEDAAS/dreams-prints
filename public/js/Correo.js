// Inicializa EmailJS con el ID del usuario (clave pública)
(function() {
    emailjs.init("KY9gRqt35YF_eCCKA");
})();

// Muestra el campo para introducir el código de recuperación
function mostrarCampoCodigo() {
    document.getElementById('codigo-section').style.display = 'block';
}

// Función para enviar el código de recuperación al correo del usuario
function sendRecoveryCode() {
    var email = document.getElementById('email').value;

    // Genera un código de 5 dígitos aleatorio
    var recoveryCode = Math.floor(10000 + Math.random() * 90000);

    // Define los parámetros que se enviarán a la plantilla de correo
    var templateParams = {
        email: email,
        recovery_code: recoveryCode
    };

    // Enviar el código mediante EmailJS
    emailjs.send('service_o28uckr', 'template_4oh2668', templateParams)
        .then(function(response) {
            alert('Código de recuperación enviado a ' + email);

            // Muestra la sección para que el usuario ingrese el código
            document.getElementById("codigo-section").style.display = "block";

            // Guarda el código en el backend mediante POST
            fetch('index.php?page=guardar_codigo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'correo=' + encodeURIComponent(email) + '&codigo=' + recoveryCode
            });
        }, function(error) {
            alert('Error al enviar el código: ' + JSON.stringify(error));
        });
}

// Función para validar el código ingresado por el usuario
function validarCodigo() {
    var email = document.getElementById('email').value;
    var codigo = document.getElementById('codigo').value;

    // Envía la validación al backend
    fetch('index.php?page=validar_codigo', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'correo=' + encodeURIComponent(email) + '&codigo=' + encodeURIComponent(codigo)
    })
    .then(response => response.text())
    .then(data => {
        data = data.trim();

        // Si el servidor responde con redirección, se lleva a nueva contraseña
        if (data.startsWith("index.php?page=nueva_contrasena")) {
            window.location.href = data;
        } else {
            alert(data); // Muestra mensaje de error si el código no es válido
        }
    })
    .catch(error => {
        alert("Error en la validación: " + error);
    });
}
