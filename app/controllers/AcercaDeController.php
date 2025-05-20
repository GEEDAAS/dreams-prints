<?php // Apertura del archivo PHP

/**
 * Controlador AcercaDeController
 *
 * Controlador responsable de mostrar las vistas informativas "Acerca de".
 * Este controlador no maneja lógica de negocio ni acceso a modelos.
 * Solo se encarga de renderizar contenido estático tanto para clientes como para administradores.
 */
class AcercaDeController {

    /**
     * Muestra la vista "Acerca de" destinada al cliente.
     * Este método es accedido comúnmente mediante la ruta:
     * index.php?page=acercaDe
     */
    public function index() {
        // Carga la vista ubicada en views/cliente/Acerca_de.php
        require '../app/views/cliente/Acerca_de.php';
    }

    /**
     * Muestra la vista "Acerca de" destinada al administrador.
     * Usualmente accedida mediante la ruta:
     * index.php?page=acercaDeAdmin
     */
    public function indexAdmin() {
        // Carga la vista ubicada en views/admin/Acerca_de_Admi.php
        require '../app/views/admin/Acerca_de_Admi.php';
    }
}
