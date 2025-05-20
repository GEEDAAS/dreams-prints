<?php // Inicio del archivo PHP

/**
 * Controlador FormasPagoAdminController
 * 
 * Se encarga de mostrar la vista que permite al administrador
 * gestionar las opciones de pago y visualizar tarjetas guardadas.
 * 
 * Este controlador no realiza lógica de negocio, únicamente carga la vista correspondiente.
 */
class FormasPagoAdminController {

    /**
     * Muestra la vista de métodos de pago del administrador.
     * La vista incluye:
     * - Lista editable de opciones de pago disponibles (solo frontend)
     * - Tarjetas de los clientes (nombre del titular)
     */
    public function index() {
        require '../app/views/admin/Formas_Pago_Admi.php'; // Renderiza la vista principal del módulo
    }
}
