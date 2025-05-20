<?php // Inicio del archivo PHP

// Incluir el modelo Recuperacion, que maneja la lógica de códigos y restablecimiento de contraseñas
require_once __DIR__ . '/../models/Recuperacion.php';

/**
 * Controlador RecuperacionController
 * 
 * Gestiona todo el proceso de recuperación de contraseña:
 * - Mostrar formulario de recuperación
 * - Guardar código temporal
 * - Validar código
 * - Establecer nueva contraseña
 */
class RecuperacionController {

    /**
     * Muestra el formulario de recuperación donde el usuario introduce su correo y código.
     */
    public function index() {
        require_once __DIR__ . '/../views/cliente/Recuperacion.php'; // Cargar vista del formulario
    }

    /**
     * Guarda el código generado por EmailJS (o frontend) en la base de datos.
     * Se activa cuando se envía el formulario de recuperación.
     */
    public function guardar_codigo() {
        if (isset($_POST['correo'], $_POST['codigo'])) { // Verifica que ambos campos estén presentes
            $recuperacion = new Recuperacion(); // Instanciar modelo
            $recuperacion->guardarCodigo($_POST['correo'], $_POST['codigo']); // Guardar código
            echo "Código guardado"; // Respuesta simple para el frontend
        }
    }

    /**
     * Valida si el código ingresado por el usuario es correcto y está activo.
     * Si es válido, lo marca como usado y habilita la siguiente vista.
     */
    public function validar_codigo() {
        if (isset($_POST['correo'], $_POST['codigo'])) { // Verifica los campos
            $recuperacion = new Recuperacion(); // Instanciar modelo
            $valido = $recuperacion->validarCodigo($_POST['correo'], $_POST['codigo']); // Validar código

            if ($valido) {
                $recuperacion->marcarComoUsado($_POST['correo']); // Desactiva el código después de validarlo
                $_SESSION['correo_recuperacion'] = $_POST['correo']; // Guarda el correo en la sesión para usarlo luego
                echo "index.php?page=nueva_contrasena"; // Retorna la URL a redirigir desde JS
            } else {
                echo "Código inválido o expirado."; // Mensaje de error
            }
        }
    }

    /**
     * Guarda la nueva contraseña enviada desde el formulario.
     * Verifica que ambas contraseñas coincidan y actualiza en base de datos.
     */
    public function guardar_nueva_contrasena() {
        if (isset($_POST['nueva_contrasena'], $_POST['confirmar_contrasena']) && isset($_SESSION['correo_recuperacion'])) {
            $email = $_SESSION['correo_recuperacion']; // Recupera el correo almacenado en la sesión
            $nueva = $_POST['nueva_contrasena'];        // Contraseña nueva
            $confirmar = $_POST['confirmar_contrasena']; // Confirmación

            if ($nueva !== $confirmar) {
                // Si no coinciden, alerta al usuario
                echo "<script>alert('Las contraseñas no coinciden'); window.history.back();</script>";
                exit;
            }

            $hash = password_hash($nueva, PASSWORD_DEFAULT); // Encriptar la contraseña

            $recuperacion = new Recuperacion(); // Instanciar modelo

            // Si se actualiza correctamente
            if ($recuperacion->actualizarContrasenaPorCorreo($email, $hash)) {
                unset($_SESSION['correo_recuperacion']); // Limpia la sesión por seguridad
                echo "<script>alert('Contraseña actualizada exitosamente'); window.location.href='index.php?page=sesion';</script>";
            } else {
                // Si falla, mostrar error y regresar
                echo "<script>alert('No se pudo actualizar la contraseña. Intente de nuevo.'); window.history.back();</script>";
            }
        }
    }

}
