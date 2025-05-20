<?php
// Se incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Se define la clase Pago, encargada de registrar y gestionar los pagos de las compras
class Pago {
    // Propiedad privada para almacenar la conexión a la base de datos
    private $conn;

    // Constructor que establece la conexión a la base de datos al crear una instancia
    public function __construct() {
        $db = new Database();           // Se crea una instancia de la clase Database
        $this->conn = $db->conectar();  // Se guarda la conexión en la propiedad $conn
    }

    // Método para registrar un nuevo pago asociado a una compra
    public function registrar($idCompra, $tipoPago) {
        // Consulta SQL para insertar el pago con estado inicial 'Pendiente'
        $sql = "INSERT INTO pago (idCompra, tipoPago, estadoPago)
                VALUES (:idCompra, :tipoPago, 'Pendiente')";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':idCompra', $idCompra);     // Se vincula el ID de la compra
        $stmt->bindParam(':tipoPago', $tipoPago);     // Se vincula el tipo de pago
        return $stmt->execute(); // Se ejecuta y se retorna el resultado (true o false)
    }

    // Método para obtener la información del pago correspondiente a una compra específica
    public function obtenerPorCompra($idCompra) {
        $sql = "SELECT * FROM pago WHERE idCompra = :idCompra"; // Consulta para buscar el pago por ID de compra
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':idCompra', $idCompra); // Se vincula el ID
        $stmt->execute(); // Se ejecuta la consulta
        return $stmt->fetch(PDO::FETCH_ASSOC); // Se retorna el resultado como arreglo asociativo
    }

    // Método para actualizar el estado de pago de una compra (por ejemplo: Aprobado, Rechazado)
    public function actualizarEstado($idCompra, $estado) {
        $sql = "UPDATE pago SET estadoPago = :estado WHERE idCompra = :id"; // Consulta de actualización
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->execute(['estado' => $estado, 'id' => $idCompra]); // Se ejecuta con los parámetros dados
    }

}
