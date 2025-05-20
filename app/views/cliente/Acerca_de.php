<?php
// Verificación de sesión: solo permite el acceso si el usuario tiene rol 'Cliente'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Cliente') {
    header("Location: index.php?page=sesion"); // Redirige a la página de sesión
    exit(); // Termina la ejecución
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

  <!-- Librería de íconos Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Estilos específicos para esta vista -->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Acerca_De.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Idea_Nuevo.css">
</head>

<body>
  <!-- Barra de navegación principal -->
  <nav class="navigation">
    <a href="index.php?page=inicio" class="logo">
      <img src="<?= BASE_URL ?>Image/Logo.jpg" alt="Dreams & Prints Logo">
      <span>Dreams & Prints</span>
    </a>
    <a href="index.php?page=inicio"><i class="fas fa-home"></i> Inicio</a>
    <a href="index.php?page=catalogo"><i class="fas fa-th-list"></i> Catálogo</a>
    <a href="index.php?page=historial"><i class="fas fa-receipt"></i> Historial</a>
    <a href="index.php?page=formasPago"><i class="fas fa-credit-card"></i> Formas de Pago</a>
    <a href="index.php?page=idea"><i class="fas fa-lightbulb"></i> Ideas</a>
    <a href="index.php?page=acercaDe" class="active"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
    <a href="index.php?page=cuenta"><i class="fas fa-user-circle"></i> Cuenta</a>
  </nav>

  <!-- Contenido principal de la sección "Acerca de" -->
  <div class="about-container">
    <div class="about-header">
      <h1>Acerca de Nosotros</h1>
      <p>Descubre más sobre Dreams & Prints y nuestra misión.</p>
    </div>

    <div class="about-content">
      <!-- Sección de Problemática -->
      <h2>Problemática</h2>
      <p align="justify">...</p>
      <ul align="justify">
        <li><strong>...</strong> ...</li>
        <!-- Resto de las problemáticas detalladas -->
      </ul>

      <!-- Sección de Justificación -->
      <h2>Justificación</h2>
      <p align="justify">...</p>
      <ul align="justify">
        <li><strong>Usuarios:</strong> ...</li>
        <li><strong>Proveedores de servicios de impresión 3D:</strong> ...</li>
        <li><strong>Empresas locales:</strong> ...</li>
        <li><strong>Sector Industrial:</strong> ...</li>
        <li><strong>Investigación y desarrollo:</strong> ...</li>
      </ul>
      <p align="justify">También se incluye más sectores...</p>
    </div>
  </div>

  <!-- Pie de página con información de contacto y redes sociales -->
  <div class="footer">
    <p>&copy; 2024 Dreams & Prints. Todos los derechos reservados.</p>
    <p>Contáctanos: 
      <a href="tel:+520012345678">+52 00 1234 5678</a> | 
      <a href="mailto:soporte@dreamsandprints.com">soporte@dreamsandprints.com</a>
    </p>
    <p>Síguenos en nuestras redes sociales:
      <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
      <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
      <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
      <a href="#" onclick="abrirConsultaModal()"><i class="fas fa-envelope"></i> Consulta</a>
    </p>
  </div>

  <!-- Modal de contacto/consulta personalizado -->
  <div id="modalConsulta" class="modal">
    <div class="modal-content">
      <span class="cerrar-modal" onclick="cerrarConsultaModal()">&times;</span>
      <h3>Enviar Consulta</h3>
      <form id="consultaForm" onsubmit="enviarConsultaPorCorreo(event)">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

        <button type="submit">Enviar</button>
      </form>
    </div>
  </div>

  <!-- Inclusión del script JavaScript para esta vista -->
  <script src="<?= BASE_URL ?>js/Acerca_De.js"></script>
</body>

</html>
