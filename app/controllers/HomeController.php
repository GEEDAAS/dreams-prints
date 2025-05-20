<?php // Inicio del archivo PHP

/**
 * Controlador HomeController
 * 
 * Este controlador se encarga de cargar la vista principal del cliente
 * al acceder al sistema (por ejemplo: index.php?page=inicio).
 */
class HomeController {

    /**
     * Método principal que muestra la página inicial del cliente.
     * Generalmente se accede vía ruta: index.php?page=inicio
     */
    public function index() {
        // Incluir la vista principal del cliente
        require '../app/views/cliente/Principal.php';
    }
}
