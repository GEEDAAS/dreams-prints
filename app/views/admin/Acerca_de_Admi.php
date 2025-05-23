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
    <a href="index.php?page=ConsultarCliente"><i class="fas fa-search"></i> Consultar Clientes</a>
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
      <p align="justify">
        En el país no hay grandes empresas u organizaciones que realicen de manera formal la producción
        de piezas personalizadas en impresión 3D por pedido, por lo tanto, es un área de oportunidad para cubrir un
        mercado con poca o nula oferta.
      </p>
      <p align="justify">
        He aquí algunas problemáticas que analizamos para este proyecto:
      </p>
      <ul align="justify">
        <li><strong>Escasez de competencia en la fabricación de piezas personalizadas en 3D por pedido de manera
            formal:</strong> Se observa una notable ausencia de competidores en el mercado de fabricación de piezas en
          3D por pedido de manera formal.</li>
        <li><strong>Falta de aplicaciones para pedido en línea de piezas impresas:</strong> Hasta la fecha, no se ha
          identificado ninguna aplicación dedicada exclusivamente al pedido en línea de piezas impresas en 3D.</li>
        <li><strong>Baja popularidad de los servicios de impresión 3D en México y en especial en la región:</strong> En
          México, y en particular en la ciudad de León, adquirir servicios de impresión 3D no es una práctica común
          debido a la escasez de negocios que ofrezcan este tipo de servicios.</li>
      </ul>

      <h2>Justificación</h2>
      <p align="justify">La escasa competencia en la fabricación de piezas en 3D por pedido, la falta de aplicaciones
        dedicadas para realizar pedidos en línea de piezas impresas y la baja popularidad de los servicios de impresión
        3D en México y en especial en la ciudad de León, Guanajuato, representan oportunidades significativas para
        introducir una solución innovadora que responda a estas necesidades.</p>
      <p align="justify">Además, esta aplicación web permitirá a los usuarios solicitar y personalizar piezas impresas
        en 3D de manera eficiente y segura, mediante una plataforma intuitiva y fácil de usar. Con la integración de
        servicios en la nube, se facilitará la gestión de pedidos, el seguimiento de la producción y la comunicación
        entre los usuarios y los proveedores de servicios de impresión 3D, lo que mejorará la experiencia del usuario y
        aumentará la eficiencia operativa.</p>
      <p align="justify">Los principales beneficiados que podría tener el desarrollo de la investigación serían los
        siguientes:</p>
      <ul align="justify">
        <li><strong>Usuarios:</strong> Los usuarios que requieren piezas impresas en 3D se beneficiarían al tener acceso
          a una plataforma conveniente y eficiente para solicitar y personalizar sus piezas.</li>
        <li><strong>Proveedores de servicios de impresión 3D:</strong> La aplicación les permitiría gestionar de manera
          más eficiente los pedidos y la producción, mejorando la comunicación con los clientes y optimizando sus
          procesos internos.</li>
        <li><strong>Empresas locales:</strong> Las empresas locales que colaboran como proveedores de servicios de
          impresión 3D podrían experimentar un aumento en la demanda de sus productos creados con esta tecnología.</li>
        <li><strong>Sector Industrial:</strong> Esto podría conducir a una mayor innovación en el diseño y la
          fabricación de productos, así como a una mayor eficiencia en los procesos de producción.</li>
        <li><strong>Investigación y desarrollo:</strong> Los centros educativos que realizan investigación y desarrollo
          en el campo de la impresión 3D podrían beneficiarse al tener acceso a una amplia gama de servicios y opciones
          de impresión para sus proyectos.</li>
      </ul>
      <p align="justify">También se incluye más sectores como la manufacturera, la de salud, sustentabilidad,
        arquitectura y diseño, y muchas otras más que se podrían beneficiar de una aplicación móvil que optimiza el
        proceso de fabricación de piezas en impresión 3D.</p>
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
      <a href="#" onclick="abrirConsultaModal()"><i class="fas fa-envelope"></i> Consulta</a>
    </p>
  </div>

  <!-- Botones de control de edición -->
  <button class="edit-button" onclick="enableEditMode()">Editar Texto</button>
  <button class="save-button" onclick="saveChanges()">Guardar Cambios</button>

  <!-- Script JS que controla la edición del contenido -->
  <script src="<?= BASE_URL ?>js/Acerca_De_Admi.js"></script>

</body>
</html>
