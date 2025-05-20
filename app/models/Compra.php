<?php
// Se incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Se define la clase Compra, que contiene métodos para gestionar las compras de los clientes
class Compra {
    // Propiedad privada para almacenar la conexión a la base de datos
    private $conn;

    // Constructor de la clase que inicializa la conexión a la base de datos
    public function __construct() {
        $db = new Database(); // Se instancia la clase Database
        $this->conn = $db->conectar(); // Se guarda la conexión en la propiedad $conn
    }

    // Método público para registrar una nueva compra
    public function registrarCompra($idCliente, $total) {
        // Consulta SQL para insertar una nueva compra con estado 'Pendiente' y fecha actual
        $sql = "INSERT INTO compra (idCliente, fechaCompra, estadoCompra, montoTotal)
                VALUES (:idCliente, CURDATE(), 'Pendiente', :total)";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':idCliente', $idCliente); // Se vincula el parámetro idCliente
        $stmt->bindParam(':total', $total); // Se vincula el parámetro total
        $stmt->execute(); // Se ejecuta la inserción
        return $this->conn->lastInsertId(); // Se retorna el ID generado de la compra
    }

    // Método público para obtener todas las compras ordenadas por fecha
    public function obtenerTodas() {
        $sql = "SELECT * FROM compra ORDER BY fechaCompra ASC"; // Consulta para obtener todas las compras
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->execute(); // Se ejecuta la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se retornan todas las compras como arreglo asociativo
    }

    // Método público para actualizar el estado de una compra
    public function actualizarEstado($idCompra, $estado) {
        $sql = "UPDATE compra SET estadoCompra = :estado WHERE idCompra = :id"; // Consulta SQL de actualización
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        // Se ejecuta la consulta con los parámetros proporcionados
        $stmt->execute(['estado' => $estado, 'id' => $idCompra]);
    }        
}
