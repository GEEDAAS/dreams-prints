<?php // Inicio del archivo PHP

/**
 * Controlador CarritoController
 * 
 * Encargado de gestionar el carrito de compras almacenado en la sesión del usuario.
 * Las operaciones incluyen agregar, eliminar, vaciar y mostrar productos del carrito.
 */
class CarritoController {

    /**
     * Agrega un nuevo producto personalizado al carrito.
     * 
     * Datos esperados vía POST:
     * - producto: nombre del producto
     * - dimension: tamaño del producto
     * - material: tipo de material
     * - color: color seleccionado
     * - precio: costo total del producto
     * 
     * Al finalizar, muestra el contenido actualizado del carrito.
     */
    public function agregar() {
        if (session_status() === PHP_SESSION_NONE) session_start(); // Iniciar sesión si no está iniciada

        // Obtener datos del formulario POST
        $producto  = $_POST['producto'] ?? '';
        $dimension = $_POST['dimension'] ?? '';
        $material  = $_POST['material'] ?? '';
        $color     = $_POST['color'] ?? '';
        $precio    = floatval($_POST['precio']); // Convertir a número decimal

        // Validación mínima para evitar registros incompletos
        if (!$producto || !$dimension || !$material || !$color) {
            http_response_code(400);           // Código HTTP 400: Bad Request
            echo "Datos incompletos";          // Mensaje de error
            return;
        }

        // Agregar el producto al arreglo del carrito en la sesión
        $_SESSION['carrito'][] = [
            'producto'  => $producto,
            'dimension' => $dimension,
            'material'  => $material,
            'color'     => $color,
            'precio'    => $precio
        ];

        // Mostrar el carrito actualizado en respuesta
        $this->mostrar();
    }

    /**
     * Elimina un producto del carrito según su índice en el array.
     * 
     * Dato esperado vía POST:
     * - index: posición del producto a eliminar dentro del carrito
     */
    public function eliminar() {
        if (session_status() === PHP_SESSION_NONE) session_start(); // Iniciar sesión si es necesario

        $index = $_POST['index'] ?? -1; // Índice recibido desde el frontend

        // Validar que el índice exista antes de eliminar
        if (isset($_SESSION['carrito'][$index])) {
            unset($_SESSION['carrito'][$index]);                // Eliminar el ítem
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar array para evitar huecos
        }

        $this->mostrar(); // Mostrar el contenido actualizado del carrito
    }

    /**
     * Elimina todos los productos del carrito (resetea la sesión).
     */
    public function vaciar() {
        if (session_status() === PHP_SESSION_NONE) session_start(); // Asegura la sesión activa
        unset($_SESSION['carrito']); // Elimina completamente el arreglo del carrito
        $this->mostrar();            // Muestra carrito vacío
    }

    /**
     * Muestra el contenido actual del carrito como respuesta JSON.
     * 
     * Retorna:
     * - html: representación HTML del carrito (para frontend)
     * - total: suma de todos los precios
     * - count: número de productos en el carrito
     */
    public function mostrar() {
        if (session_status() === PHP_SESSION_NONE) session_start(); // Asegura sesión iniciada

        $carrito = $_SESSION['carrito'] ?? []; // Obtiene el carrito o un array vacío
        $total = 0;                            // Acumulador de total
        $html = "";                            // HTML generado dinámicamente

        // Generar HTML por cada ítem del carrito
        foreach ($carrito as $i => $item) {
            $total += $item['precio']; // Sumar al total

            // Agregar HTML de cada producto al string
            $html .= "<li>
                        <strong>{$item['producto']}</strong> - {$item['dimension']}, {$item['material']}, Color: {$item['color']}<br>
                        <span style='font-weight:bold;'>\$" . number_format($item['precio'], 2) . "</span>
                        <button onclick='eliminarItem($i)' style='margin-left:10px;'>❌</button>
                      </li>";
        }

        // Enviar respuesta JSON al frontend
        echo json_encode([
            'html'  => $html,
            'total' => number_format($total, 2), // Total con 2 decimales
            'count' => count($carrito)           // Cantidad de ítems
        ]);
    }
}
