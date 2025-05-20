<?php
// Verifica que el usuario tenga una sesión activa como 'Administrador'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: index.php?page=sesion");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D&P: Acerca de</title>

  <!-- Ícono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Librerías de íconos y hoja de estilo -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Acerca_De_Admi.css">
</head>

<body>

  <!-- Barra de navegación del administrador -->
  <nav class="navigation">
    <a href="index.php?page=admin_home" class="logo">
        <img src="<?= BASE_URL ?>Image/Logo.jpg" alt="Dreams & Prints Logo">
        <span>Dreams & Prints</span>
    </a>
    <a href="index.php?page=admin_home"><i class="fas fa-home"></i> Inicio</a>
    <a href="index.php?page=catalogo_admin"><i class="fas fa-th-list"></i> Catálogo</a>
    <a href="index.php?page=compras_admin"><i class="fas fa-box-open"></i> Gestión de Compras</a>
    <a href="index.php?page=formasPagoAdmin"><i class="fas fa-credit-card"></i> Formas de Pago</a>
    <a href="index.php?page=ideaAdmin"><i class="fas fa-tools"></i> Administrar Ideas</a>
    <a href="index.php?page=acercaDeAdmin" class="active"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
    <a href="index.php?page=cuenta_admin"><i class="fas fa-user-shield"></i> Cuenta</a>
  </nav>

  <!-- Contenedor principal de contenido editable -->
  <div class="about-container">
    <div class="about-header">
      <h1>Acerca de Nosotros</h1>
      <p>Descubre más sobre Dreams & Prints y nuestra misión.</p>
    </div>

    <!-- Contenido editable del administrador -->
    <div class="about-content" contenteditable="true">
      <h2>Problemática</h2>
      <p align="justify">...</p>
      <ul align="justify">
        <li><strong>...</strong> ...</li>
        <!-- Lista detallada de problemáticas identificadas -->
      </ul>

      <h2>Justificación</h2>
      <p align="justify">...</p>
      <ul align="justify">
        <li><strong>Usuarios:</strong> ...</li>
        <li><strong>Proveedores de servicios de impresión 3D:</strong> ...</li>
        <li><strong>Empresas locales:</strong> ...</li>
        <li><strong>Sector Industrial:</strong> ...</li>
        <li><strong>Investigación y desarrollo:</strong> ...</li>
      </ul>
      <p align="justify">También se incluye más sectores como manufactura, salud, arquitectura, etc.</p>
    </div>
  </div>

  <!-- Pie de página con datos de contacto -->
  <div class="footer">
    <p>&copy; 2024 Dreams & Prints. Todos los derechos reservados.</p>
    <p>Contáctanos: 
      <a href="tel:+520012345678">+52 00 1234 5678</a> | 
      <a href="mailto:soporte@dreamsandprints.com">soporte@dreamsandprints.com</a>
    </p>
    <p>Síguenos en nuestras redes sociales:
      <a href="#"><i class="fab fa-facebook"></i> Facebook</a>,
      <a href="#"><i class="fab fa-twitter"></i> Twitter</a>,
      <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
    </p>
  </div>

  <!-- Botones de control de edición -->
  <button class="edit-button" onclick="enableEditMode()">Editar Texto</button>
  <button class="save-button" onclick="saveChanges()">Guardar Cambios</button>

  <!-- Script JS que controla la edición del contenido -->
  <script src="<?= BASE_URL ?>js/Acerca_De_Admi.js"></script>

</body>
</html>
