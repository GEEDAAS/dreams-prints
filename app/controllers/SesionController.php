<?php // Inicio del archivo PHP

// Incluir el modelo Usuario que permite validar credenciales y obtener datos del usuario
require_once '../app/models/Usuario.php';

/**
 * Controlador SesionController
 * 
 * Encargado de gestionar el inicio y cierre de sesión:
 * - Mostrar el formulario de login
 * - Validar credenciales
 * - Iniciar sesión del cliente o administrador
 * - Cerrar sesión
 */
class SesionController {

    /**
     * Muestra el formulario de inicio de sesión.
     * Ruta: index.php?page=sesion
     */
    public function index() {
        require '../app/views/cliente/Sesion.php'; // Cargar vista del formulario de login
    }

    /**
     * Valida las credenciales enviadas por el formulario de login.
     * - Verifica correo y contraseña
     * - Inicia sesión si es correcto
     * - Redirige según tipo de usuario
     */
    public function validar() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") { // Solo procesa si es solicitud POST

            $correo = $_POST['email'] ?? '';     // Correo ingresado
            $password = $_POST['password'] ?? ''; // Contraseña ingresada

            $usuario = new Usuario();                    // Instancia del modelo Usuario
            $datos = $usuario->obtenerPorCorreo($correo); // Buscar usuario por correo

            // Si el correo existe y la contraseña es válida
            if ($datos && password_verify($password, $datos['contraseñaCliente'])) {

                // Verificar que el estado del cliente sea 'Activo'
                if ($datos['estadoCliente'] !== 'Activo') {
                    echo "<script>alert('Tu cuenta está inactiva. Por favor, contacta al administrador.');
                          window.location.href='index.php?page=sesion';</script>";
                    return; // Detiene ejecución si la cuenta no está activa
                }

                // Iniciar sesión con los datos del usuario
                $_SESSION['idCliente'] = $datos['idCliente'];
                $_SESSION['nombre'] = $datos['nombreCliente'];
                $_SESSION['correo'] = $datos['correoCliente'];
                $_SESSION['rol'] = $datos['tipoUsuario']; // Puede ser 'Cliente' o 'Administrador'

                // Redirigir según el tipo de usuario
                if ($datos['tipoUsuario'] === 'Administrador') {
                    echo "<script>alert('Bienvenido administrador {$datos['nombreCliente']}');
                          window.location.href='index.php?page=admin_home';</script>";
                } else {
                    echo "<script>alert('Bienvenido {$datos['nombreCliente']}');
                          window.location.href='index.php?page=inicio';</script>";
                }

            } else {
                // Si el correo no existe o la contraseña es incorrecta
                echo "<script>alert('Credenciales incorrectas');
                      window.location.href='index.php?page=sesion';</script>";
            }
        }
    }

    /**
     * Cierra la sesión actual del usuario y redirige al formulario de login.
     */
    public function cerrar() {
        session_destroy(); // Destruye todos los datos de sesión
        header('Location: index.php?page=sesion'); // Redirige al login
    }
}
