<?php // Inicio del archivo PHP

// Incluir el modelo Producto, el cual maneja la lógica de acceso a la tabla de productos
require_once __DIR__ . '/../models/Producto.php';

/**
 * Controlador CatalogoAdminController
 *
 * Este controlador gestiona todas las acciones administrativas sobre el catálogo:
 * - Visualización de productos
 * - Agregado de nuevos productos
 * - Eliminación lógica (cambio de estado a "No Disponible")
 * - Edición y actualización de productos existentes
 */
class CatalogoAdminController {

    /**
     * Muestra todos los productos al administrador.
     * Se carga la vista con la tabla o tarjetas del catálogo.
     */
    public function index() {
        $producto = new Producto();                  // Crear instancia del modelo Producto
        $productos = $producto->obtenerTodos();      // Obtener todos los productos activos e inactivos

        require '../app/views/admin/Catalogo_Admi.php'; // Renderizar la vista del administrador
    }

    /**
     * Agrega un nuevo producto al catálogo.
     * Se ejecuta cuando se envía el formulario con datos y archivo (imagen).
     */
    public function agregar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Validar que se trata de una solicitud POST

            // Recibir los datos enviados desde el formulario
            $nombre      = $_POST['nombre']      ?? '';     // Nombre del producto
            $descripcion = $_POST['descripcion'] ?? '';     // Descripción del producto
            $precio      = $_POST['precio']      ?? 0;      // Precio del producto
            $categoria   = $_POST['categoria']   ?? '';     // Categoría del producto
            $stock       = $_POST['stock']       ?? 0;      // Stock inicial del producto
            $estado      = $_POST['estado']      ?? 'Disponible'; // Estado inicial del producto

            // Procesar imagen subida (opcional)
            $imagenBinaria = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['tmp_name'] !== '') {
                $imagenBinaria = file_get_contents($_FILES['imagen']['tmp_name']); // Leer imagen en binario
            }

            $producto = new Producto(); // Crear nueva instancia del modelo
            $exito = $producto->agregarProducto($nombre, $descripcion, $precio, $categoria, $stock, $estado, $imagenBinaria); // Guardar producto

            // Mostrar mensaje según resultado y redirigir
            if ($exito) {
                echo "<script>alert('Producto agregado exitosamente'); window.location.href='index.php?page=catalogo_admin';</script>";
            } else {
                echo "<script>alert('Error al agregar producto'); window.location.href='index.php?page=catalogo_admin';</script>";
            }
        }
    }

    /**
     * Realiza una eliminación lógica del producto.
     * Esto cambia su estado a "No Disponible", pero no lo elimina físicamente.
     */
    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];                            // ID del producto a modificar
            $producto = new Producto();                    // Crear instancia del modelo
            $producto->cambiarEstado($id, 'No Disponible'); // Marcar como no disponible
            header('Location: index.php?page=catalogo_admin'); // Redirigir al catálogo
        }
    }

    /**
     * Actualiza un producto ya existente con los datos enviados por formulario.
     * Solo realiza la actualización si detecta cambios reales.
     */
    public function actualizarProducto() {
        require_once __DIR__ . '/../models/Producto.php'; // Asegura que el modelo esté disponible
        $producto = new Producto();

        $id = $_POST['idProducto']; // ID del producto a actualizar

        // Nuevos datos enviados por el administrador
        $nuevo = [
            'nombre'      => trim($_POST['nombre']),
            'descripcion' => trim($_POST['descripcion']),
            'precio'      => $_POST['precio'],
            'categoria'   => trim($_POST['categoria']),
            'stock'       => $_POST['stock']
        ];

        // Obtener los datos actuales desde la base de datos
        $actual = $producto->obtenerPorId($id);
        if (!$actual) {
            echo "Producto no encontrado.";
            return;
        }

        // Comparar los datos nuevos con los actuales para evitar actualizaciones innecesarias
        $cambios = array_diff_assoc($nuevo, [
            'nombre'      => $actual['nombreProducto'],
            'descripcion' => $actual['descripcionProducto'],
            'precio'      => $actual['precioProducto'],
            'categoria'   => $actual['categoriaProducto'],
            'stock'       => $actual['cantidadProductoStock']
        ]);

        // Si no hubo cambios, notificar al administrador
        if (empty($cambios)) {
            echo "No se realizaron cambios.";
        } else {
            // Aplicar actualización si hubo diferencias
            $producto->actualizar($id, $nuevo);
            echo "Producto actualizado correctamente.";
        }
    }
}
