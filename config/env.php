<?php
/**
 * Carga las variables del archivo .env y las define como constantes globales.
 */

// Ruta al archivo .env (uno arriba de /config)
$env = parse_ini_file(__DIR__ . '/../.env');

// Verifica que todas las variables requeridas estén definidas
$requeridas = ['DB_HOST', 'DB_NAME', 'DB_USER'];

foreach ($requeridas as $clave) {
    if (!isset($env[$clave]) || $env[$clave] === '') {
        die("❌ ERROR: Falta la variable '$clave' en el archivo .env o está vacía.");
    }
}

// Define constantes globales que serán usadas en database.php u otros archivos
define('DB_HOST', $env['DB_HOST']);
define('DB_NAME', $env['DB_NAME']);
define('DB_USER', $env['DB_USER']);
define('DB_PASS', $env['DB_PASS']);
