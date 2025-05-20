<?php
// Se incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Se define la clase Cliente, la cual contiene métodos para gestionar los datos de los clientes
class Cliente {

    // Método privado estático para obtener la conexión a la base de datos
    private static function getConexion() {
        $db = new Database(); // Se crea una nueva instancia de la clase Database
        return $db->conectar(); // Se retorna la conexión PDO a la base de datos
    }

    // Método público estático para obtener la información de un cliente por su ID
    public static function obtenerPorId($idCliente) {
        $conexion = self::getConexion(); // Se obtiene la conexión
        // Se prepara una consulta para seleccionar los datos del cliente
        $stmt = $conexion->prepare("SELECT idCliente, nombreCliente, correoCliente, tipoUsuario, imagenPerfil FROM cliente WHERE idCliente = ?");
        $stmt->execute([$idCliente]); // Se ejecuta la consulta con el ID del cliente
        return $stmt->fetch(PDO::FETCH_ASSOC); // Se retorna el resultado como un arreglo asociativo
    }

    // Método público estático para actualizar nombre, correo e imagen de perfil del cliente
    public static function actualizarDatos($idCliente, $nombre, $correo, $imagenPerfil) {
        $conexion = self::getConexion(); // Se obtiene la conexión
        // Se prepara la consulta de actualización de los datos
        $stmt = $conexion->prepare("UPDATE cliente SET nombreCliente = ?, correoCliente = ?, imagenPerfil = ? WHERE idCliente = ?");
        return $stmt->execute([$nombre, $correo, $imagenPerfil, $idCliente]); // Se ejecuta con los valores proporcionados
    }

    // Método público estático para actualizar la contraseña del cliente
    public static function actualizarContrasena($idCliente, $nuevaClaveHash) {
        $conexion = self::getConexion(); // Se obtiene la conexión
        // Se prepara la consulta para actualizar la contraseña encriptada del cliente
        $stmt = $conexion->prepare("UPDATE cliente SET contraseñaCliente = ? WHERE idCliente = ?");
        return $stmt->execute([$nuevaClaveHash, $idCliente]); // Se ejecuta con la nueva contraseña y el ID
    }

    // Método público estático para desactivar (inhabilitar) la cuenta del cliente
    public static function desactivarCuenta($idCliente) {
        $conexion = self::getConexion(); // Se obtiene la conexión
        // Se prepara la consulta para cambiar el estado del cliente a 'Inactivo'
        $stmt = $conexion->prepare("UPDATE cliente SET estadoCliente = 'Inactivo' WHERE idCliente = ?");
        return $stmt->execute([$idCliente]); // Se ejecuta con el ID correspondiente
    }

    // Método adicional para actualizar la contraseña usando el correo del cliente (útil para recuperación)
    public static function actualizarContrasenaPorCorreo($correo, $nuevaClaveHash) {
        $conexion = self::getConexion(); // Se obtiene la conexión
        // Se prepara la consulta para actualizar la contraseña a partir del correo
        $stmt = $conexion->prepare("UPDATE cliente SET contraseñaCliente = ? WHERE correoCliente = ?");
        return $stmt->execute([$nuevaClaveHash, $correo]); // Se ejecuta con los datos proporcionados
    }

}
