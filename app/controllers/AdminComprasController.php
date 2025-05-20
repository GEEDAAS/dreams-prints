<?php

// Se cargan los modelos que se utilizarán en este controlador
require_once __DIR__ . '/../models/Compra.php';     // Modelo para operaciones sobre compras
require_once __DIR__ . '/../models/Pago.php';       // Modelo para actualizar/ver estado de pagos
require_once __DIR__ . '/../models/Impresion.php';  // Modelo para gestionar el estado de impresiones
require_once __DIR__ . '/../models/Usuario.php';    // Modelo para obtener datos de clientes

/**
 * Controlador AdminComprasController
 *
 * Permite al administrador:
 * - Ver todas las compras realizadas
 * - Actualizar el estado de los pagos
 * - Actualizar el estado de las impresiones
 */
class AdminComprasController {

    /**
     * Método principal que carga la vista de administración de compras.
     * Este método recupera todas las compras y adjunta:
     * - Su respectivo pago
     * - Las impresiones asociadas
     * - Los datos del cliente que realizó la compra
     */
    public function index() {
        $compraModel = new Compra();            // Instancia del modelo de compras
        $pagoModel = new Pago();                // Instancia del modelo de pagos
        $impresionModel = new Impresion();      // Instancia del modelo de impresiones
        $usuarioModel = new Usuario();          // Instancia del modelo de usuarios

        $compras = $compraModel->obtenerTodas();  // Obtener todas las compras registradas

        // Enriquecer cada compra con datos adicionales
        foreach ($compras as $i => $compra) {
            // Se agrega el pago correspondiente
            $compras[$i]['pago'] = $pagoModel->obtenerPorCompra($compra['idCompra']);
            // Se agregan todas las impresiones asociadas
            $compras[$i]['impresiones'] = $impresionModel->obtenerPorCompra($compra['idCompra']);
            // Se agregan los datos del cliente
            $compras[$i]['cliente'] = $usuarioModel->obtenerPorId($compra['idCliente']);
        }

        // Renderizar la vista de administración de compras con la información enriquecida
        require __DIR__ . '/../views/admin/Compras_Admi.php';
    }

    /**
     * Actualiza el estado del pago de una compra específica.
     * Recibe vía POST:
     * - idCompra: ID de la compra a modificar
     * - estadoPago: nuevo estado del pago ("Aprobado", "Rechazado")
     */
    public function actualizarEstadoPago() {
        // Asegurar la carga de modelos (en caso de uso independiente)
        require_once __DIR__ . '/../models/Pago.php';
        require_once __DIR__ . '/../models/Impresion.php';
        require_once __DIR__ . '/../models/Compra.php';

        $id = $_POST['idCompra'];               // ID de la compra a modificar
        $nuevoEstado = $_POST['estadoPago'];   // Estado nuevo: Aprobado o Rechazado

        $pagoModel = new Pago();
        $pagoModel->actualizarEstado($id, $nuevoEstado);  // Se actualiza el estado del pago

        $impresionModel = new Impresion();
        $compraModel = new Compra();

        // Si el pago fue aprobado, se inicia el proceso de impresión
        if ($nuevoEstado === 'Aprobado') {
            $impresionModel->actualizarEstadoPorCompra($id, 'En proceso');

        // Si el pago fue rechazado, se cancelan impresión y compra
        } elseif ($nuevoEstado === 'Rechazado') {
            $impresionModel->actualizarEstadoPorCompra($id, 'Cancelada');
            $compraModel->actualizarEstado($id, 'Cancelada');
        }

        // Confirmación de operación
        echo "Estado de pago actualizado.";
    }

    /**
     * Actualiza el estado de una impresión individual.
     * Si todas las impresiones asociadas a la compra están completadas,
     * se marca también la compra como completada.
     * 
     * Recibe vía POST:
     * - idImpresion: ID de la impresión modificada
     * - estadoImpresion: nuevo estado de esa impresión
     * - idCompra: ID de la compra asociada
     */
    public function actualizarEstadoImpresion() {
        require_once __DIR__ . '/../models/Impresion.php';
        require_once __DIR__ . '/../models/Compra.php';

        $idImpresion = $_POST['idImpresion'];        // ID de la impresión
        $estado = $_POST['estadoImpresion'];         // Nuevo estado: Completada, Cancelada, etc.
        $idCompra = $_POST['idCompra'];              // ID de la compra asociada

        $impresionModel = new Impresion();
        $impresionModel->actualizarEstado($idImpresion, $estado);  // Actualizar estado de la impresión

        // Si se completó una impresión, verificamos si TODAS están completadas
        if ($estado === 'Completada') {
            $todas = $impresionModel->obtenerPorCompra($idCompra);  // Obtener todas las impresiones de la compra

            // Verificar si todas tienen estado 'Completada'
            $todasCompletadas = array_reduce($todas, fn($c, $i) => $c && $i['estadoImpresion'] === 'Completada', true);

            // Si es así, actualizar también el estado general de la compra
            if ($todasCompletadas) {
                $compraModel = new Compra();
                $compraModel->actualizarEstado($idCompra, 'Completada');
            }
        }

        echo "Estado de impresión actualizado.";
    }
}
