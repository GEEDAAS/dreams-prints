<?php // Inicio del archivo PHP

// Se incluye el modelo Cliente, necesario para obtener y modificar datos del cliente
require_once __DIR__ . '/../models/Cliente.php';

/**
 * Controlador CuentaController
 * 
 * Gestiona las acciones de la cuenta del cliente:
 * - Visualización de datos
 * - Actualización de nombre, correo e imagen
 * - Cambio de contraseña
 * - Desactivación de cuenta
 */
class CuentaController {

    /**
     * Muestra la vista de perfil del cliente con sus datos actuales.
     */
    public function cuenta() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Inicia sesión si aún no se ha iniciado
        }

        // Si no hay sesión activa, redirigir al login
        if (!isset($_SESSION['idCliente'])) {
            header("Location: index.php?page=sesion");
            exit();
        }

        $clienteModel = new Cliente(); // Crear instancia del modelo
        $datosCliente = $clienteModel->obtenerPorId($_SESSION['idCliente']); // Obtener datos del cliente por ID

        require_once __DIR__ . '/../views/cliente/cuenta.php'; // Cargar la vista del cliente
    }

    /**
     * Permite al cliente actualizar su nombre, correo electrónico e imagen de perfil.
     */
    public function actualizarDatos() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Asegurar sesión activa
        }

        // Validar que sea una solicitud POST con sesión válida
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['idCliente'])) {
            $nombre = $_POST['nombre'];  // Nuevo nombre
            $correo = $_POST['correo'];  // Nuevo correo

            // Procesar imagen de perfil
            $imagenPerfil = null;

            // Si se sube una nueva imagen, procesarla como binario
            if (!empty($_FILES['imagenPerfil']['tmp_name'])) {
                $imagenPerfil = file_get_contents($_FILES['imagenPerfil']['tmp_name']);
            } else {
                // Si no se sube una imagen, mantener la anterior
                $clienteModel = new Cliente();
                $datosCliente = $clienteModel->obtenerPorId($_SESSION['idCliente']);
                $imagenPerfil = $datosCliente['imagenPerfil'];
            }

            $clienteModel = new Cliente();
            $clienteModel->actualizarDatos($_SESSION['idCliente'], $nombre, $correo, $imagenPerfil); // Guardar cambios

            header("Location: index.php?page=cuenta"); // Redirigir al perfil
            exit();
        }
    }

    /**
     * Permite cambiar la contraseña del cliente.
     * Verifica que la nueva y la confirmación coincidan antes de aplicar el cambio.
     */
    public function cambiarContrasena() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Iniciar sesión si es necesario
        }

        // Validar método POST y sesión
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['idCliente'])) {
            $nuevaClave = $_POST['nuevaClave'];         // Contraseña nueva ingresada
            $confirmarClave = $_POST['confirmarClave']; // Confirmación de contraseña

            if ($nuevaClave === $confirmarClave) {
                $hash = password_hash($nuevaClave, PASSWORD_DEFAULT); // Encriptar contraseña
                $clienteModel = new Cliente();
                $clienteModel->actualizarContrasena($_SESSION['idCliente'], $hash); // Guardar nueva contraseña

                header("Location: index.php?page=cuenta");
                exit();
            } else {
                // Contraseñas no coinciden, guardar mensaje de error en sesión
                $_SESSION['error'] = "Las contraseñas no coinciden.";
                header("Location: index.php?page=cuenta");
                exit();
            }
        }
    }

    /**
     * Desactiva la cuenta del cliente actual.
     * Cierra sesión y redirige a la pantalla de login con un mensaje.
     */
    public function eliminarCuenta() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Asegurar sesión activa
        }

        // Validar método y existencia de sesión
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['idCliente'])) {
            $clienteModel = new Cliente();
            $clienteModel->desactivarCuenta($_SESSION['idCliente']); // Cambia estado del cliente en la base de datos

            session_destroy(); // Finaliza la sesión

            // Mostrar mensaje emergente y redirigir
            echo "<script>
                alert('Cuenta eliminada correctamente.');
                window.location.href = 'index.php?page=sesion';
            </script>";
            exit();
        }
    }
}
