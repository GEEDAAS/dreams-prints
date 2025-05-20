<?php
// Se incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Se define la clase Impresion, que gestiona las configuraciones y estados de las impresiones
class Impresion {
    // Propiedad privada que almacenará la conexión a la base de datos
    private $conn;

    // Constructor que establece la conexión a la base de datos al crear una instancia
    public function __construct() {
        $db = new Database();           // Se crea una nueva instancia de la clase Database
        $this->conn = $db->conectar();  // Se guarda la conexión en la propiedad $conn
    }

    // Método para registrar una nueva impresión asociada a una compra
    public function registrar($idCompra, $configuracion) {
        // Se prepara la consulta SQL para insertar una nueva impresión con estado 'Pendiente'
        $sql = "INSERT INTO impresion (idCompra, configuracion, estadoImpresion)
                VALUES (:idCompra, :configuracion, 'Pendiente')";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':idCompra', $idCompra); // Se vincula el ID de la compra
        $stmt->bindParam(':configuracion', $configuracion); // Se vincula la configuración de impresión
        return $stmt->execute(); // Se ejecuta la consulta y se retorna el resultado
    }

    // Método para obtener las impresiones asociadas a una compra específica
    public function obtenerPorCompra($idCompra) {
        $sql = "SELECT * FROM impresion WHERE idCompra = :idCompra"; // Consulta SQL filtrada por compra
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':idCompra', $idCompra); // Se vincula el ID de la compra
        $stmt->execute(); // Se ejecuta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se devuelve el resultado como arreglo asociativo
    }

    // Método para actualizar el estado de una impresión por su ID
    public function actualizarEstado($idImpresion, $estado) {
        $sql = "UPDATE impresion SET estadoImpresion = :estado WHERE idImpresion = :id"; // Consulta de actualización
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->execute(['estado' => $estado, 'id' => $idImpresion]); // Se ejecuta con los parámetros correspondientes
    }

    // Método alternativo para actualizar el estado de impresión usando el ID de la compra
    public function actualizarEstadoPorCompra($idCompra, $estado) {
        $sql = "UPDATE impresion SET estadoImpresion = :estado WHERE idCompra = :id"; // Consulta SQL
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->execute(['estado' => $estado, 'id' => $idCompra]); // Se ejecuta con los valores proporcionados
    }

}
