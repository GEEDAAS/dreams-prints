<?php
// Se incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Se define la clase Recuperacion, utilizada para manejar el proceso de recuperación de contraseñas
class Recuperacion {
    // Propiedad para almacenar la conexión a la base de datos
    private $conexion;

    // Constructor que inicializa la conexión al instanciar la clase
    public function __construct() {
        $db = new Database();                // Se crea una instancia de la clase Database
        $this->conexion = $db->conectar();   // Se guarda la conexión PDO en la propiedad $conexion
    }

    // Método para guardar un nuevo código de recuperación en la base de datos
    public function guardarCodigo($correo, $codigo) {
        // Se prepara una consulta para insertar el código asociado a un correo
        $stmt = $this->conexion->prepare("INSERT INTO codigos_recuperacion (correo, codigo) VALUES (?, ?)");
        return $stmt->execute([$correo, $codigo]); // Se ejecuta con los parámetros recibidos
    }

    // Método para validar si un código es correcto, no ha expirado y fue generado recientemente
    public function validarCodigo($correo, $codigo) {
        // Consulta que verifica si el código coincide, no ha expirado, y fue generado hace menos de 10 minutos
        $stmt = $this->conexion->prepare("SELECT * FROM codigos_recuperacion 
            WHERE correo = ? AND codigo = ? AND expirado = FALSE 
            AND creado_en >= NOW() - INTERVAL 10 MINUTE");
        $stmt->execute([$correo, $codigo]); // Se ejecuta con los parámetros dados
        return $stmt->fetch(PDO::FETCH_ASSOC); // Se retorna la coincidencia como arreglo asociativo (o false si no hay)
    }

    // Método para marcar como "usado" (expirado) un código de recuperación después de validarlo
    public function marcarComoUsado($correo) {
        $stmt = $this->conexion->prepare("UPDATE codigos_recuperacion SET expirado = TRUE WHERE correo = ?");
        return $stmt->execute([$correo]); // Se actualiza el estado de todos los códigos asociados al correo
    }

    // Método para actualizar la contraseña de un cliente usando su correo electrónico
    public function actualizarContrasenaPorCorreo($correo, $nuevaClaveHash) {
        $stmt = $this->conexion->prepare("UPDATE cliente SET contraseñaCliente = ? WHERE correoCliente = ?");
        $stmt->execute([$nuevaClaveHash, $correo]); // Se ejecuta con la nueva contraseña hasheada
        return $stmt->rowCount(); // Retorna el número de filas afectadas por la consulta
    }

}
