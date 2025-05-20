<?php // Inicio del archivo PHP

// Incluir el modelo Usuario que se encarga de registrar y verificar existencia de correos
require_once '../app/models/Usuario.php';

/**
 * Controlador RegistroController
 * 
 * Gestiona el proceso de registro de nuevos usuarios (clientes):
 * - Muestra el formulario de registro
 * - Valida que el correo no esté registrado
 * - Guarda el nuevo usuario
 */
class RegistroController {

    /**
     * Muestra la vista de registro para el cliente.
     * Ruta: index.php?page=registro
     */
    public function index() {
        require '../app/views/cliente/Registro.php'; // Carga la vista con el formulario
    }

    /**
     * Procesa el formulario de registro enviado por el cliente.
     * Realiza las siguientes acciones:
     * - Valida datos
     * - Verifica que el correo no esté duplicado
     * - Guarda al nuevo usuario con la contraseña encriptada
     */
    public function registrar() {
        // Solo permitir solicitudes tipo POST (evita acceso por URL)
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Obtener valores del formulario, usar valor por defecto si no se envían
            $nombre = $_POST['name'] ?? '';
            $correo = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Encriptar la contraseña antes de guardarla
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $usuario = new Usuario(); // Instanciar el modelo
            $existe = $usuario->obtenerPorCorreo($correo); // Verificar si ya existe el correo

            if ($existe) {
                // Si ya existe, mostrar alerta y redirigir
                echo "<script>alert('El correo ya está registrado.'); window.location.href='index.php?page=registro';</script>";
            } else {
                // Intentar registrar al nuevo usuario
                if ($usuario->registrar($nombre, $correo, $passwordHash)) {
                    echo "<script>alert('Registro exitoso.'); window.location.href='index.php?page=sesion';</script>";
                } else {
                    // Si ocurre un error durante el registro
                    echo "<script>alert('Error al registrar.'); window.location.href='index.php?page=registro';</script>";
                }
            }
        } else {
            // Rechazar cualquier acceso que no sea POST
            echo "Acceso no permitido.";
        }
    }
}
