<?php // Inicio del archivo PHP

// Incluir el modelo Idea, que gestiona todas las operaciones relacionadas con ideas
require_once __DIR__ . '/../models/Idea.php';

/**
 * Controlador IdeaController
 * 
 * Este controlador permite al cliente:
 * - Ver ideas activas (propias y de otros usuarios)
 * - Agregar nuevas ideas
 * - Buscar ideas
 * - Eliminar (inactivar) sus propias ideas
 */
class IdeaController {

    private $modelo; // Atributo que almacena una instancia del modelo Idea

    /**
     * Constructor que inicializa el modelo Idea.
     */
    public function __construct() {
        $this->modelo = new Idea();
    }

    /**
     * Muestra todas las ideas activas.
     * Las ideas mostradas incluyen el nombre del cliente que las creó.
     */
    public function cliente() {
        if (session_status() === PHP_SESSION_NONE) session_start(); // Inicia sesión si no está activa
        $idCliente = $_SESSION['idCliente']; // Se obtiene el ID del cliente actual (puede usarse para controles)
        $ideas = $this->modelo->obtenerActivas(); // Obtener todas las ideas activas (JOIN con nombre del cliente)
        require '../app/views/cliente/Idea.php'; // Cargar la vista de ideas del cliente
    }

    /**
     * Agrega una nueva idea con los datos enviados por formulario.
     */
    public function agregar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica que la solicitud sea POST
            if (session_status() === PHP_SESSION_NONE) session_start(); // Asegura la sesión

            // Obtener datos del formulario
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $categoria = $_POST['categoria'];
            $idCliente = $_SESSION['idCliente'];

            // Procesar imagen subida
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagen = file_get_contents($_FILES['imagen']['tmp_name']); // Leer imagen como binario
            }

            // Guardar la nueva idea en la base de datos
            $this->modelo->agregar($titulo, $descripcion, $imagen, $categoria, $idCliente);

            // Redirigir al módulo de ideas
            header('Location: index.php?page=idea');
            exit();
        }
    }

    /**
     * Busca ideas activas por título o categoría.
     * El término se recibe vía POST desde un formulario.
     */
    public function buscar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) session_start(); // Inicia sesión si es necesario
            $termino = $_POST['busqueda']; // Término de búsqueda ingresado
            $ideas = $this->modelo->buscarPorTituloOCategoria($termino, true); // Buscar solo entre ideas activas
            require '../app/views/cliente/Idea.php'; // Mostrar los resultados en la misma vista
        }
    }

    /**
     * Elimina una idea cambiando su estado a 'Inactiva'.
     * Solo se ejecuta si se recibe una solicitud POST con el ID de la idea.
     */
    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idIdea = $_POST['idIdea']; // ID de la idea a inactivar
            $this->modelo->cambiarEstado($idIdea, 'Inactiva'); // Actualizar el estado en la base de datos

            // Mostrar mensaje de confirmación y redirigir
            echo "<script>
                alert('Idea eliminada correctamente.');
                window.location.href = 'index.php?page=idea';
            </script>";
            exit;
        } else {
            // Si no se accede por POST, redirigir de forma segura
            header('Location: index.php?page=idea');
            exit;
        }
    }
}
