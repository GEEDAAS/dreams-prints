<?php
// Se incluye el archivo de configuración de base de datos
require_once __DIR__ . '/../../config/database.php';

// Se define la clase Idea, que gestiona las ideas propuestas por los clientes
class Idea {
    // Propiedad para almacenar la conexión a la base de datos
    private $conn;

    // Constructor que inicializa la conexión al instanciar la clase
    public function __construct() {
        $db = new Database();           // Se crea una instancia de la clase Database
        $this->conn = $db->conectar();  // Se almacena la conexión PDO en $conn
    }

    // Método para agregar una nueva idea a la base de datos
    public function agregar($titulo, $descripcion, $imagen, $categoria, $idCliente) {
        // Consulta SQL para insertar una idea con estado inicial 'Activa'
        $sql = "INSERT INTO idea (titulo, descripcion, imagenIdea, categoriaProducto, estadoIdea, idCliente)
                VALUES (:titulo, :descripcion, :imagen, :categoria, 'Activa', :idCliente)";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        // Se ejecuta con los datos proporcionados
        $stmt->execute([
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'imagen' => $imagen,
            'categoria' => $categoria,
            'idCliente' => $idCliente
        ]);
    }

    // Método para obtener todas las ideas activas de un cliente específico
    public function obtenerActivasPorCliente($idCliente) {
        $sql = "SELECT * FROM idea WHERE idCliente = :id AND estadoIdea = 'Activa'"; // Consulta filtrada
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->execute(['id' => $idCliente]); // Se ejecuta con el ID del cliente
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se devuelve la lista de ideas activas
    }

    // Método para obtener todas las ideas activas de todos los clientes, incluyendo su nombre
    public function obtenerActivas() {
        $sql = "SELECT i.*, c.nombreCliente
                FROM idea i
                JOIN cliente c ON i.idCliente = c.idCliente
                WHERE i.estadoIdea = 'Activa'"; // Consulta con JOIN para incluir el nombre del cliente
        $stmt = $this->conn->query($sql); // Se ejecuta directamente ya que no tiene parámetros
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se devuelve el resultado
    }

    // Método para obtener todas las ideas sin importar su estado
    public function obtenerTodas() {
        $sql = "SELECT i.*, c.nombreCliente 
                    FROM idea i 
                    JOIN cliente c ON i.idCliente = c.idCliente 
                    ORDER BY i.estadoIdea DESC"; // Ordenadas por estado ('Activa' antes que 'Inactiva')
        $stmt = $this->conn->query($sql); // Se ejecuta sin parámetros
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se devuelve el resultado completo
    }

    // Método para buscar ideas por título o categoría, con opción a filtrar solo activas
    public function buscarPorTituloOCategoria($termino, $soloActivas = true) {
        $sql = "SELECT i.*, u.nombreCliente FROM idea i 
                JOIN cliente u ON i.idCliente = u.idCliente 
                WHERE (titulo LIKE :t OR categoriaProducto LIKE :t)";
        if ($soloActivas) $sql .= " AND estadoIdea = 'Activa'"; // Agrega condición si solo se buscan activas
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta final
        $stmt->execute(['t' => "%$termino%"]); // Se busca usando comodines
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se devuelven los resultados
    }

    // Método para cambiar el estado de una idea (por ejemplo: de Activa a Inactiva o viceversa)
    public function cambiarEstado($idIdea, $estado) {
        $sql = "UPDATE idea SET estadoIdea = :estado WHERE idIdea = :id"; // Consulta de actualización
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->execute(['estado' => $estado, 'id' => $idIdea]); // Se ejecuta con los parámetros dados
    }
}
