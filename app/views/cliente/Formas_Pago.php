<?php
// Inicia sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Verifica si hay una sesión válida del cliente
if (!isset($_SESSION['idCliente'])) {
    header("Location: index.php?page=sesion");
    exit();
}

// Verifica que el rol sea 'Cliente'
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
  <title>D&P: Formas de Pago</title>

  <!-- Icono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Estilos e íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Formas_Pago.css">
</head>

<body>
  <!-- Barra de navegación -->
  <nav class="navigation">
    <a href="index.php?page=inicio" class="logo">
      <img src="<?= BASE_URL ?>Image/Logo.jpg" alt="Dreams & Prints Logo">
      <span>Dreams & Prints</span>
    </a>
    <a href="index.php?page=inicio"><i class="fas fa-home"></i> Inicio</a>
    <a href="index.php?page=catalogo"><i class="fas fa-th-list"></i> Catálogo</a>
    <a href="index.php?page=historial"><i class="fas fa-receipt"></i> Historial</a>
    <a href="index.php?page=formasPago" class="active"><i class="fas fa-credit-card"></i> Formas de Pago</a>
    <a href="index.php?page=idea"><i class="fas fa-lightbulb"></i> Ideas</a>
    <a href="index.php?page=acercaDe"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
    <a href="index.php?page=cuenta"><i class="fas fa-user-circle"></i> Cuenta</a>
  </nav>

  <!-- Contenedor principal -->
  <div class="payment-container">
    <!-- Encabezado de la sección -->
    <div class="payment-header">
      <h1>Formas de Pago</h1>
    </div>

    <!-- Métodos disponibles -->
    <div class="payment-methods">
      <h2>Opciones Disponibles:</h2>
      <ul>
        <li><i class="fas fa-credit-card"></i> Tarjeta de Crédito o Débito (Visa, MasterCard, American Express)</li>
        <li><i class="fas fa-university"></i> Transferencia Bancaria (Contactos por Whatsapp al 477-FER-0000)</li>
        <li><i class="fas fa-money-bill-wave"></i> Pago en Efectivo (Pagas en los servicios que tenemos)</li>
      </ul>
    </div>

    <!-- Formulario para guardar tarjeta -->
    <div class="payment-form">
      <h2>Ingresa tus Datos de Pago:</h2>
      <form action="index.php?page=guardar_tarjeta" method="POST">
        <label for="nombre">Nombre del Titular:</label>
        <input type="text" id="nombre" name="nombreTitular" required>

        <label for="numeroTarjeta">Número de Tarjeta:</label>
        <input type="text" id="numeroTarjeta" name="numeroTarjeta" required pattern="\d{16}">

        <label for="expiracion">Fecha de Expiración:</label>
        <input type="month" id="expiracion" name="expiracion" required>

        <label for="codigoSeguridad">Código de Seguridad (CVV):</label>
        <input type="password" id="codigoSeguridad" name="codigoSeguridad" required pattern="\d{3}">

        <button type="submit">Guardar Tarjeta</button>
      </form>
    </div>

    <!-- Tarjetas guardadas por el cliente -->
    <div id="tarjetasGuardadas" class="payment-methods">
      <h2>Tarjetas Guardadas:</h2>
      <ul id="tarjetasList">
        <?php
        // Consulta a la base de datos para obtener tarjetas del cliente
        require_once __DIR__ . '/../../models/TarjetaCliente.php';
        $modelo = new TarjetaCliente();
        $tarjetas = $modelo->obtenerPorCliente($_SESSION['idCliente']);
        ?>

        <?php if ($tarjetas && count($tarjetas) > 0): ?>
          <?php foreach ($tarjetas as $t): ?>
            <?php $ultimos4 = substr($t['numeroTarjeta'], -4); ?>
            <li>
              <i class="fas fa-credit-card"></i>
              <strong><?= htmlspecialchars($t['nombreTitular']) ?></strong> –
              **** **** **** <?= htmlspecialchars($ultimos4) ?> –
              Exp: <?= htmlspecialchars($t['mesExpiracion']) ?>/<?= htmlspecialchars($t['anioExpiracion']) ?>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li>No tienes tarjetas guardadas.</li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <!-- Pie de página -->
  <div class="footer">
    <p>&copy; 2024 Dreams & Prints. Todos los derechos reservados.</p>
    <p>Visita nuestra <a href="#">página principal</a>.</p>
  </div>

</body>
</html>
