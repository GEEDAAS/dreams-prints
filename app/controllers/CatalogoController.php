<?php // Inicio del archivo PHP

// Incluir el modelo Producto que contiene las operaciones relacionadas con la base de datos de productos
require_once '../app/models/Producto.php';

/**
 * Controlador CatalogoController
 * 
 * Encargado de mostrar el catálogo de productos para el cliente.
 * Permite aplicar filtros por nombre o categoría a través de parámetros GET.
 */
class CatalogoController {

    /**
     * Método principal para renderizar el catálogo del cliente.
     * Carga todos los productos disponibles o aplica filtros si se especifican en la URL.
     */
    public function index() {
        $producto = new Producto(); // Crear instancia del modelo Producto

        // Obtener filtros desde la URL si existen
        $nombre = $_GET['nombre'] ?? '';      // Filtro por nombre del producto
        $categoria = $_GET['categoria'] ?? ''; // Filtro por categoría

        // Verificar si se debe aplicar filtrado
        if (!empty($nombre) || !empty($categoria)) {
            // Obtener productos filtrados por nombre o categoría
            $productos = $producto->filtrar($nombre, $categoria);
        } else {
            // Si no hay filtros, obtener todos los productos disponibles
            $productos = $producto->obtenerTodos();
        }

        // Incluir la vista de catálogo para el cliente
        require '../app/views/cliente/Catalogo.php';
    }
}
