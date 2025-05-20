<?php // Inicio del archivo PHP

// Incluir modelos necesarios para procesar una compra
require_once '../app/models/Producto.php';   // Acceso a productos (precio, stock)
require_once '../app/models/Compra.php';     // Registro de compras
require_once '../app/models/Impresion.php';  // Registro de configuraciones de impresión
require_once '../app/models/Pago.php';       // Registro de pagos

/**
 * Controlador PagoController
 * 
 * Gestiona el flujo del pago:
 * - Muestra el formulario de pago si hay productos en el carrito
 * - Registra la compra, configuraciones e impresión
 * - Resta el stock de productos
 * - Limpia el carrito tras confirmación
 */
class PagoController {

    /**
     * Muestra la vista de pago solo si el carrito contiene productos.
     */
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start(); // Asegura la sesión activa

        $carrito = $_SESSION['carrito'] ?? []; // Obtener carrito de sesión
        if (empty($carrito)) {
            // Si el carrito está vacío, alertar y redirigir
            echo "<script>alert('Tu carrito está vacío.'); window.location.href='index.php?page=catalogo';</script>";
            return;
        }

        // Cargar la vista de pago
        require '../app/views/cliente/Pago.php';
    }

    /**
     * Confirma la compra:
     * - Registra la compra, impresiones y pago
     * - Disminuye el stock
     * - Elimina el carrito de sesión
     */
    public function confirmar() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Verificar sesión y carrito válidos
        if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito']) || !isset($_SESSION['correo'])) {
            echo "<script>alert('Sesión inválida.'); window.location.href='index.php?page=catalogo';</script>";
            return;
        }

        // Re-incluir modelos necesarios
        require_once '../app/models/Producto.php';
        require_once '../app/models/Compra.php';
        require_once '../app/models/Impresion.php';
        require_once '../app/models/Pago.php';

        $productoModel = new Producto();
        $compraModel = new Compra();
        $impresionModel = new Impresion();
        $pagoModel = new Pago();

        // Obtener ID del cliente desde correo
        require_once '../app/models/Usuario.php';
        $usuarioModel = new Usuario();
        $cliente = $usuarioModel->obtenerPorCorreo($_SESSION['correo']);
        $idCliente = $cliente['idCliente'];

        // Calcular total de la compra
        $total = array_sum(array_column($_SESSION['carrito'], 'precio'));

        // Registrar la compra en la base de datos
        $idCompra = $compraModel->registrarCompra($idCliente, $total);

        $errorStock = false; // Bandera para detectar productos con stock insuficiente

        // Registrar cada producto como impresión y restar stock
        foreach ($_SESSION['carrito'] as $item) {
            $producto = $productoModel->obtenerPorNombre($item['producto']);
            if ($producto && $producto['cantidadProductoStock'] >= 1) {
                // Restar 1 al stock
                $productoModel->restarStock($producto['idProducto'], 1);

                // Configuración personalizada en JSON
                $config = json_encode([
                    'producto' => $item['producto'],
                    'dimension' => $item['dimension'],
                    'material' => $item['material'],
                    'color' => $item['color']
                ]);

                // Registrar la impresión
                $impresionModel->registrar($idCompra, $config);
            } else {
                $errorStock = true;
            }
        }

        // Registrar el tipo de pago (enviado por POST)
        $tipoPago = $_POST['tipoPago'];
        $pagoModel->registrar($idCompra, $tipoPago);

        // Limpiar carrito después de registrar todo
        unset($_SESSION['carrito']);

        // Mostrar mensaje según disponibilidad de stock
        if ($errorStock) {
            echo "<script>alert('Pago registrado, pero algunos productos no tenían suficiente stock.');
                  window.location.href='index.php?page=catalogo';</script>";
        } else {
            echo "<script>alert('¡Gracias por tu compra!');
                  window.location.href='index.php?page=catalogo';</script>";
        }
    }

}
