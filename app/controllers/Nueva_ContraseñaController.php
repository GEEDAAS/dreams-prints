<?php // Inicio del archivo PHP

// Incluir el modelo Recuperacion, utilizado para procesos de recuperación y actualización de contraseña
require_once __DIR__ . '/../models/Recuperacion.php';

/**
 * Controlador NuevaContrasenaController
 * 
 * Se encarga de mostrar la vista donde el usuario establece su nueva contraseña,
 * luego de haber validado su identidad mediante un código de recuperación.
 */
class NuevaContrasenaController {

    /**
     * Muestra la vista 'Nueva_Contraseña.php' donde el cliente podrá escribir su nueva contraseña.
     * Generalmente se accede a esta vista después de validar el código de recuperación.
     */
    public function index() {
        require_once __DIR__ . '/../views/cliente/Nueva_Contraseña.php'; // Carga la vista para cambiar la contraseña
    }
}
