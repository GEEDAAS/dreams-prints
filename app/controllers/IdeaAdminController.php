<?php // Inicio del archivo PHP

// Incluir el modelo Idea que contiene las operaciones sobre la base de datos de ideas
require_once __DIR__ . '/../models/Idea.php';

/**
 * Controlador IdeaAdminController
 * 
 * Este controlador permite al administrador:
 * - Ver todas las ideas (activas e inactivas)
 * - Buscar ideas por término
 * - Cambiar el estado de las ideas (activar o inactivar)
 */
class IdeaAdminController {

    private $modelo; // Instancia del modelo Idea

    /**
     * Constructor que inicializa el modelo Idea.
     */
    public function __construct() {
        $this->modelo = new Idea();
    }

    /**
     * Muestra todas las ideas sin importar su estado.
     * Se utiliza para renderizar la vista principal del módulo de ideas del administrador.
     */
    public function ver() {
        $ideas = $this->modelo->obtenerTodas(); // Obtener todas las ideas desde el modelo
        include '../app/views/admin/Idea_Admi.php'; // Cargar la vista del administrador
    }

    /**
     * Permite buscar ideas por título o categoría (sin filtrar por estado).
     * Este método se accede vía POST desde un formulario.
     */
    public function buscar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $termino = $_POST['busqueda'] ?? ''; // Término de búsqueda ingresado por el admin
            $ideas = $this->modelo->buscarPorTituloOCategoria($termino, false); // Buscar ideas sin filtrar por estado
            include '../app/views/admin/Idea_Admi.php'; // Mostrar resultados en la misma vista
        } else {
            header("Location: index.php?page=ideaAdmin"); // Redirigir si se intenta acceder sin POST
        }
    }

    /**
     * Elimina (inhabilita) una idea cambiando su estado a 'Inactiva'.
     * Se realiza mediante un formulario POST con el ID de la idea.
     */
    public function eliminar() {
        if (isset($_POST['idIdea'])) {
            $this->modelo->cambiarEstado($_POST['idIdea'], 'Inactiva'); // Cambiar estado en la base de datos

            // Mostrar alerta y redirigir
            echo "<script>alert('Idea eliminada correctamente.');
            window.location.href = 'index.php?page=ideaAdmin';</script>";
        }
    }

    /**
     * Reactiva una idea cambiando su estado a 'Activa'.
     * Se accede también por POST enviando el ID de la idea.
     */
    public function activar() {
        if (isset($_POST['idIdea'])) {
            $this->modelo->cambiarEstado($_POST['idIdea'], 'Activa'); // Cambiar estado a Activa

            // Mostrar alerta y redirigir
            echo "<script>alert('Idea reactivada correctamente.');
            window.location.href = 'index.php?page=ideaAdmin';</script>";
        }
    }
}
