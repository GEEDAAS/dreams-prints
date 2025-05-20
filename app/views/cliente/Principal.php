<?php
// Verifica que el usuario esté autenticado como 'Cliente'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Cliente') {
    header("Location: index.php?page=sesion");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D&P: Inicio</title>

  <!-- Ícono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Estilos e íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Principal.css">
</head>

<body>
  <div class="content">

    <!-- Banner superior con mensaje de bienvenida -->
    <header class="top-banner">
      <p id="welcome-message">
        <?php
          if (session_status() === PHP_SESSION_NONE) session_start();
          echo "Bienvenido, " . htmlspecialchars($_SESSION['nombre']);
        ?>
      </p>
    </header>

    <!-- Barra de navegación -->
    <nav class="navigation">
      <a href="index.php?page=inicio" class="logo">
        <img src="<?= BASE_URL ?>Image/Logo.jpg" alt="Dreams & Prints Logo">
        <span>Dreams & Prints</span>
      </a>
      <a href="index.php?page=inicio" class="active"><i class="fas fa-home"></i> Inicio</a>
      <a href="index.php?page=catalogo"><i class="fas fa-th-list"></i> Catálogo</a>
      <a href="index.php?page=historial"><i class="fas fa-receipt"></i> Historial</a>
      <a href="index.php?page=formasPago"><i class="fas fa-credit-card"></i> Formas de Pago</a>
      <a href="index.php?page=idea"><i class="fas fa-lightbulb"></i> Ideas</a>
      <a href="index.php?page=acercaDe"><i class="fas fa-info-circle"></i> Acerca de</a>
      <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
      <a href="index.php?page=cuenta"><i class="fas fa-user-circle"></i> Cuenta</a>
    </nav>

    <!-- Sección principal del contenido -->
    <main class="content">
      <div class="intro">
        <h1><span>Bienvenido a</span><br>Dreams & Prints</h1>
        <button class="cta" onclick="document.getElementById('about-us').scrollIntoView({ behavior: 'smooth' });">
          Conócenos
        </button>
      </div>

      <!-- Imagen de presentación -->
      <div class="images">
        <img src="<?= BASE_URL ?>Image/Logo.jpg" alt="Dreams & Prints">
      </div>

      <!-- Descripción destacada -->
      <p class="description">
        Impulsa tus ideas con piezas 3D personalizadas de manera rápida y sencilla.
      </p>

      <!-- Sección informativa: ¿Quiénes Somos? -->
      <section id="about-us" class="values">
        <h2>¿Quiénes Somos?</h2>
        <p align="justify">
          Somos una empresa dedicada a la impresión 3D personalizada, ofreciendo soluciones
          rápidas y eficientes para materializar tus ideas. Nuestra misión es proporcionar productos de alta
          calidad y un excelente servicio al cliente, asegurándonos de que cada pieza cumpla con los estándares
          más altos.
        </p>

        <!-- Video de fondo promocional -->
        <div class="video-container">
          <video autoplay muted loop id="bg-video">
            <source src="<?= BASE_URL ?>Video/3DPrint.mp4" type="video/mp4">
          </video>
        </div>

        <!-- Valores de la empresa -->
        <h2>Nuestros Valores</h2>
        <ul align="justify">
          <li><strong>Innovación:</strong> Estamos comprometidos con la innovación constante, utilizando la
            última tecnología en impresión 3D para ofrecer productos únicos y personalizados.
          </li>
          <li><strong>Calidad:</strong> Nos esforzamos por garantizar la mejor calidad en cada pieza,
            cuidando cada detalle para superar las expectativas de nuestros clientes.
          </li>
          <li><strong>Servicio al Cliente:</strong> Creemos en la importancia de un excelente servicio al
            cliente, ofreciendo atención personalizada y soluciones adaptadas a las necesidades de cada cliente.
          </li>
        </ul>

        <!-- Qué hace la empresa -->
        <h2>Lo Que Hacemos</h2>
        <p align="justify">
          Nos especializamos en la fabricación de piezas personalizadas mediante la impresión 3D.
          Atendemos a una amplia variedad de sectores, desde particulares que desean crear objetos únicos, hasta
          empresas que necesitan prototipos funcionales. Nuestro proceso es simple y eficiente, permitiéndote realizar
          pedidos en línea de manera rápida y sencilla.
        </p>

        <!-- Innovación como pilar estratégico -->
        <h2>Innovación</h2>
        <p align="justify">
          Nos destacamos por nuestra capacidad de innovar en el mercado de la impresión 3D, ofreciendo
          soluciones únicas que no se encuentran fácilmente en otros lugares. Aprovechamos las oportunidades del
          mercado, cubriendo una necesidad latente en la producción de piezas personalizadas por pedido.
        </p>
      </section>
    </main>
  </div>

  <!-- Script JS para animaciones o eventos -->
  <script src="<?= BASE_URL ?>js/Principal.js"></script>

</body>
</html>
