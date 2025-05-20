<?php
// Se incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Se define la clase TarjetaCliente, encargada de gestionar las tarjetas registradas por los clientes
class TarjetaCliente {
    // Propiedad privada para almacenar la conexión a la base de datos
    private $conn;

    // Constructor que inicializa la conexión a la base de datos
    public function __construct() {
        $db = new Database();           // Se crea una instancia de la clase Database
        $this->conn = $db->conectar();  // Se obtiene y almacena la conexión PDO
    }

    // Método para guardar una nueva tarjeta registrada por un cliente
    public function guardar($datos) {
        // Consulta SQL para insertar una nueva tarjeta en la tabla TarjetaCliente
        $sql = "INSERT INTO TarjetaCliente 
            (idCliente, nombreTitular, numeroTarjeta, mesExpiracion, anioExpiracion, codigoSeguridad)
            VALUES (:idCliente, :nombreTitular, :numeroTarjeta, :mesExpiracion, :anioExpiracion, :codigoSeguridad)";
        
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        // Se vinculan los valores recibidos desde el arreglo $datos
        $stmt->bindParam(':idCliente', $datos['idCliente']);
        $stmt->bindParam(':nombreTitular', $datos['nombreTitular']);
        $stmt->bindParam(':numeroTarjeta', $datos['numeroTarjeta']);
        $stmt->bindParam(':mesExpiracion', $datos['mesExpiracion']);
        $stmt->bindParam(':anioExpiracion', $datos['anioExpiracion']);
        $stmt->bindParam(':codigoSeguridad', $datos['codigoSeguridad']);
        return $stmt->execute(); // Se ejecuta y se retorna el resultado (true/false)
    }

    // Método para obtener todas las tarjetas registradas por un cliente específico
    public function obtenerPorCliente($idCliente) {
        // Se seleccionan solo los campos visibles (no incluye código de seguridad)
        $sql = "SELECT nombreTitular, numeroTarjeta, mesExpiracion, anioExpiracion 
                FROM TarjetaCliente WHERE idCliente = :idCliente";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':idCliente', $idCliente); // Se vincula el ID del cliente
        $stmt->execute(); // Se ejecuta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se devuelven las tarjetas como arreglo asociativo
    }

    // Método para obtener el nombre de los titulares de todas las tarjetas registradas (para el administrador)
    public function obtenerTodas() {
        $sql = "SELECT nombreTitular FROM TarjetaCliente"; // Consulta simplificada solo con el nombre del titular
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->execute(); // Se ejecuta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se retorna el resultado
    }
}
