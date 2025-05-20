<?php

// Activa la visualización de errores en tiempo de ejecución (útil para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia una nueva sesión o retoma la existente
session_start(); // 🔐 Importante para mantener datos de usuario autenticado

// Si no se proporciona un parámetro 'page' en la URL, redirige al controlador por defecto
if (!isset($_GET['page'])) {
    header('Location: index.php?page=PageHome'); // Página de inicio o default
    exit;
}

// Obtiene la ruta base del script (usada para recursos y enlaces)
$basePath = dirname($_SERVER['SCRIPT_NAME']);
define('BASE_URL', $basePath . '/');

// Carga las rutas definidas por el desarrollador (enrutamiento principal)
require_once '../routes/web.php';
