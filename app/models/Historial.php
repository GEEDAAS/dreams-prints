<?php
// Se incluye el archivo de configuración para establecer la conexión con la base de datos
require_once __DIR__ . '/../../config/database.php';

// Se define la clase Historial, que contiene métodos para consultar el historial de compras de un cliente
class Historial {
    // Propiedad privada que almacenará la conexión PDO
    private $conn;

    // Constructor de la clase que establece la conexión con la base de datos
    public function __construct() {
        $db = new Database(); // Se instancia la clase Database
        $this->conn = $db->conectar(); // Se obtiene y guarda la conexión en $conn
    }

    // Método público para obtener todas las compras realizadas por un cliente, junto con el estado de pago
    public function obtenerComprasPorCliente($idCliente) {
        // Consulta SQL que une las tablas 'compra' y 'pago' para mostrar detalles de pago por cada compra
        $sql = "SELECT c.*, p.tipoPago, p.estadoPago
                FROM compra c
                JOIN pago p ON c.idCompra = p.idCompra
                WHERE c.idCliente = :idCliente
                ORDER BY c.fechaCompra ASC";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':idCliente', $idCliente); // Se vincula el ID del cliente
        $stmt->execute(); // Se ejecuta la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se retorna el resultado como un arreglo de asociaciones
    }

    // Método público para obtener los detalles de impresión asociados a una compra específica
    public function obtenerImpresionesPorCompra($idCompra) {
        $sql = "SELECT * FROM impresion WHERE idCompra = :idCompra"; // Consulta SQL a tabla 'impresion'
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':idCompra', $idCompra); // Se vincula el ID de la compra
        $stmt->execute(); // Se ejecuta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se retorna la lista de impresiones asociadas
    }

    // Método público para obtener el pago relacionado a una compra específica
    public function obtenerPagoPorCompra($idCompra) {
        $sql = "SELECT * FROM pago WHERE idCompra = :idCompra"; // Consulta SQL a tabla 'pago'
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':idCompra', $idCompra); // Se vincula el ID de la compra
        $stmt->execute(); // Se ejecuta
        return $stmt->fetch(PDO::FETCH_ASSOC); // Se retorna el resultado como un arreglo asociativo
    }
}
