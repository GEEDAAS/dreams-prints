<?php
// Se incluye el archivo de configuración de la base de datos
require_once __DIR__ . '/../../config/database.php';

// Se define la clase Admin, que contiene métodos para gestionar cuentas de tipo administrador
class Admin {

    // Método privado estático para obtener la conexión a la base de datos
    private static function getConexion() {
        $db = new Database(); // Se crea una nueva instancia de la clase Database
        return $db->conectar(); // Se retorna el objeto de conexión PDO
    }

    // Método público estático para obtener los datos de un administrador por su ID
    public static function obtenerPorId($idCliente) {
        $conexion = self::getConexion(); // Se obtiene la conexión a la base de datos
        // Se prepara una consulta para seleccionar los datos del cliente (administrador) por su ID
        $stmt = $conexion->prepare("SELECT idCliente, nombreCliente, correoCliente, tipoUsuario, imagenPerfil FROM cliente WHERE idCliente = ?");
        $stmt->execute([$idCliente]); // Se ejecuta la consulta con el parámetro recibido
        return $stmt->fetch(PDO::FETCH_ASSOC); // Se devuelve el resultado como un arreglo asociativo
    }

    // Método público estático para actualizar el nombre, correo e imagen de perfil del administrador
    public static function actualizarDatos($idCliente, $nombre, $correo, $imagenPerfil) {
        $conexion = self::getConexion(); // Se obtiene la conexión a la base de datos
        // Se prepara una consulta para actualizar los datos del cliente por su ID
        $stmt = $conexion->prepare("UPDATE cliente SET nombreCliente = ?, correoCliente = ?, imagenPerfil = ? WHERE idCliente = ?");
        // Se ejecuta la consulta con los valores proporcionados
        return $stmt->execute([$nombre, $correo, $imagenPerfil, $idCliente]);
    }

    // Método público estático para actualizar la contraseña del administrador
    public static function actualizarContrasena($idCliente, $nuevaClaveHash) {
        $conexion = self::getConexion(); // Se obtiene la conexión a la base de datos
        // Se prepara una consulta para actualizar la contraseña del cliente
        $stmt = $conexion->prepare("UPDATE cliente SET contraseñaCliente = ? WHERE idCliente = ?");
        // Se ejecuta la consulta con la nueva contraseña encriptada y el ID
        return $stmt->execute([$nuevaClaveHash, $idCliente]);
    }

    // Método público estático para desactivar (inhabilitar) la cuenta del administrador
    public static function desactivarCuenta($idCliente) {
        $conexion = self::getConexion(); // Se obtiene la conexión a la base de datos
        // Se prepara una consulta para actualizar el estado del cliente a 'Inactivo'
        $stmt = $conexion->prepare("UPDATE cliente SET estadoCliente = 'Inactivo' WHERE idCliente = ?");
        // Se ejecuta la consulta con el ID del cliente
        return $stmt->execute([$idCliente]);
    }

}
