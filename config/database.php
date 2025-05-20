<?php

// Carga las variables de entorno desde el archivo .env
require_once __DIR__ . '/env.php';

/**
 * Clase encargada de manejar la conexión a la base de datos mediante PDO.
 */
class Database {
    // Dirección del servidor de la base de datos (definida en .env)
    private $host = DB_HOST;

    // Nombre de la base de datos (definido en .env)
    private $db_name = DB_NAME;

    // Nombre de usuario de la base de datos (definido en .env)
    private $username = DB_USER;

    // Contraseña del usuario de la base de datos (definida en .env)
    private $password = DB_PASS;

    // Propiedad pública que almacenará la instancia de conexión PDO
    public $conn;

    /**
     * Método que establece y retorna una conexión PDO a la base de datos.
     * @return PDO|null Objeto de conexión o null si falló.
     */
    public function conectar() {
        // Inicializa la conexión como nula por defecto
        $this->conn = null;

        try {
            // Intenta crear una nueva instancia PDO con los datos del .env
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            // Establece el conjunto de caracteres UTF-8 para soportar acentos y caracteres especiales
            $this->conn->exec("set names utf8");

        } catch (PDOException $exception) {
            // En caso de error, muestra un mensaje claro al desarrollador
            echo "Error de conexión: " . $exception->getMessage();
        }

        // Devuelve el objeto de conexión o null si no se logró conectar
        return $this->conn;
    }
}
