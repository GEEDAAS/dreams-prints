<?php
// Se incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Se define la clase Usuario, que se encarga de registrar y consultar usuarios (clientes)
class Usuario {
    // Propiedad privada para almacenar la conexión a la base de datos
    private $conn;

    // Constructor que establece la conexión a la base de datos al instanciar la clase
    public function __construct() {
        $db = new Database();           // Se crea una instancia de la clase Database
        $this->conn = $db->conectar();  // Se obtiene y almacena la conexión PDO
    }

    // Método para registrar un nuevo cliente en la base de datos
    public function registrar($nombre, $correo, $contrasena) {
        try {
            // Consulta SQL para insertar un nuevo cliente con estado 'Activo' y tipo 'Cliente'
            $sql = "INSERT INTO Cliente (nombreCliente, correoCliente, contraseñaCliente, estadoCliente, tipoUsuario)
                VALUES (:nombre, :correo, :contrasena, 'Activo', 'Cliente')";
            
            $stmt = $this->conn->prepare($sql); // Se prepara la consulta
            $stmt->bindParam(':nombre', $nombre);         // Se vincula el nombre
            $stmt->bindParam(':correo', $correo);         // Se vincula el correo
            $stmt->bindParam(':contrasena', $contrasena); // Se vincula la contraseña ya hasheada
            
            return $stmt->execute(); // Se ejecuta la inserción y se retorna true si fue exitosa
        } catch (PDOException $e) {
            // En caso de error (por ejemplo, correo duplicado), se retorna false
            return false;
        }
    }

    // Método para obtener la información de un cliente usando su correo electrónico
    public function obtenerPorCorreo($correo) {
        $sql = "SELECT * FROM Cliente WHERE correoCliente = :correo"; // Consulta SQL
        $stmt = $this->conn->prepare($sql);       // Se prepara la consulta
        $stmt->bindParam(':correo', $correo);     // Se vincula el correo
        $stmt->execute();                         // Se ejecuta la consulta
        return $stmt->fetch(PDO::FETCH_ASSOC);    // Se retorna el resultado como arreglo asociativo
    }

    // Método para obtener la información de un cliente usando su ID
    public function obtenerPorId($idCliente) {
        $sql = "SELECT * FROM cliente WHERE idCliente = :id"; // Consulta SQL
        $stmt = $this->conn->prepare($sql);      // Se prepara la consulta
        $stmt->bindParam(':id', $idCliente);     // Se vincula el ID del cliente
        $stmt->execute();                        // Se ejecuta
        return $stmt->fetch(PDO::FETCH_ASSOC);   // Se retorna el resultado como arreglo asociativo
    }
}
