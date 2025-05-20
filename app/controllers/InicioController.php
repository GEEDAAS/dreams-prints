<?php // Inicio del archivo PHP

/**
 * Controlador InicioController
 * 
 * Se encarga de mostrar la página de inicio del sistema.
 * Generalmente es la primera pantalla del sitio antes del login.
 */
class InicioController {

    /**
     * Método principal que carga la vista de bienvenida o portada del sistema.
     * Ruta asociada: index.php?page=inicio
     */
    public function index() {
        // Incluir la vista de inicio ubicada en views/Inicio.php
        require_once __DIR__ . '/../views/Inicio.php';
    }
}
