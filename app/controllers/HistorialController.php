<?php // Inicio del archivo PHP

// Incluir modelo Historial, encargado de acceder a pagos e impresiones de compras
require_once '../app/models/Historial.php';
// Incluir modelo Usuario para obtener ID del cliente usando el correo
require_once '../app/models/Usuario.php';

/**
 * Controlador HistorialController
 * 
 * Permite al cliente ver su historial de compras, con detalles:
 * - Datos de compra
 * - Estado de pago
 * - Estado de impresión
 */
class HistorialController {

    /**
     * Muestra la vista del historial de compras del cliente autenticado.
     */
    public function index() {
        // Iniciar sesión si aún no está activa
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Validar que el cliente esté autenticado por su correo electrónico
        if (!isset($_SESSION['correo'])) {
            header("Location: index.php?page=sesion"); // Redirigir a login si no hay sesión
            exit();
        }

        $usuarioModel = new Usuario(); // Instanciar modelo de Usuario
        $cliente = $usuarioModel->obtenerPorCorreo($_SESSION['correo']); // Obtener datos del cliente por correo
        $idCliente = $cliente['idCliente']; // Extraer ID del cliente

        $modelo = new Historial(); // Instanciar modelo de Historial

        // Obtener todas las compras realizadas por este cliente
        $compras = $modelo->obtenerComprasPorCliente($idCliente);

        // Enriquecer cada compra con su pago e impresiones asociadas
        foreach ($compras as $i => $compra) {
            $compras[$i]['pago'] = $modelo->obtenerPagoPorCompra($compra['idCompra']);              // Estado del pago
            $compras[$i]['impresiones'] = $modelo->obtenerImpresionesPorCompra($compra['idCompra']); // Detalle de impresiones
        }

        // Renderizar la vista con los datos del historial
        require __DIR__ . '/../views/cliente/HistorialCompras.php';
    }
}
