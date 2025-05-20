<?php // Inicio del archivo PHP

// Incluir el modelo Admin, que contiene métodos para obtener y actualizar información del administrador
require_once __DIR__ . '/../models/Admin.php';

/**
 * Controlador CuentaAdmiController
 * 
 * Administra las acciones relacionadas con la cuenta del administrador:
 * - Ver datos de la cuenta
 * - Actualizar nombre, correo e imagen
 * - Cambiar contraseña
 * - Eliminar (desactivar) cuenta
 */
class CuentaAdmiController {

    /**
     * Muestra la vista de cuenta del administrador con sus datos cargados.
     */
    public function cuentaAdmi() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Iniciar sesión si no se ha iniciado
        }

        // Si el administrador no ha iniciado sesión, redirigir al login
        if (!isset($_SESSION['idCliente'])) {
            header("Location: index.php?page=sesion");
            exit();
        }

        $adminModel = new Admin(); // Instanciar el modelo
        $datosAdmin = $adminModel->obtenerPorId($_SESSION['idCliente']); // Obtener los datos del admin actual

        require_once __DIR__ . '/../views/admin/Cuenta_Admi.php'; // Cargar la vista correspondiente
    }

    /**
     * Actualiza nombre, correo e imagen de perfil del administrador.
     */
    public function actualizarDatos() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Iniciar sesión si no está iniciada
        }

        // Validar que la solicitud sea POST y haya sesión activa
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['idCliente'])) {
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];

            // Procesar la imagen de perfil si fue enviada
            $imagenPerfil = null;
            if (!empty($_FILES['imagenPerfil']['tmp_name'])) {
                $imagenPerfil = file_get_contents($_FILES['imagenPerfil']['tmp_name']); // Leer la imagen como binario
            } else {
                // Si no se envió una imagen nueva, usar la existente
                $adminModel = new Admin();
                $datosAdmin = $adminModel->obtenerPorId($_SESSION['idCliente']);
                $imagenPerfil = $datosAdmin['imagenPerfil'];
            }

            $adminModel = new Admin(); // Reinstanciar modelo
            $adminModel->actualizarDatos($_SESSION['idCliente'], $nombre, $correo, $imagenPerfil); // Actualizar datos

            // Redirigir nuevamente a la página de cuenta
            header("Location: index.php?page=cuenta_admin");
            exit();
        }
    }

    /**
     * Cambia la contraseña del administrador, verificando coincidencia.
     */
    public function cambiarContrasena() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Asegura sesión activa
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['idCliente'])) {
            $nuevaClave = $_POST['nuevaClave'];
            $confirmarClave = $_POST['confirmarClave'];

            // Verificar si las contraseñas coinciden
            if ($nuevaClave === $confirmarClave) {
                $hash = password_hash($nuevaClave, PASSWORD_DEFAULT); // Encriptar contraseña
                $adminModel = new Admin();
                $adminModel->actualizarContrasena($_SESSION['idCliente'], $hash); // Guardar nueva contraseña

                header("Location: index.php?page=cuenta_admin");
                exit();
            } else {
                // Si no coinciden, guardar error en sesión y redirigir
                $_SESSION['error'] = "Las contraseñas no coinciden.";
                header("Location: index.php?page=cuenta_admin");
                exit();
            }
        }
    }

    /**
     * Elimina (desactiva) la cuenta del administrador y cierra sesión.
     */
    public function eliminarCuenta() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Asegura la sesión activa
        }

        // Verifica que haya una sesión válida antes de desactivar
        if (isset($_SESSION['idCliente'])) {
            $adminModel = new Admin();
            $adminModel->desactivarCuenta($_SESSION['idCliente']); // Cambia estado en BD

            session_destroy(); // Eliminar sesión

            // Mostrar mensaje de confirmación y redirigir
            echo "<script>
                alert('Cuenta eliminada correctamente.');
                window.location.href = 'index.php?page=sesion';
            </script>";
            exit();
        }
    }
}
