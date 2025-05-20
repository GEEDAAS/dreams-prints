<?php
// Verifica que el usuario sea administrador
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
  <title>D&P: Formas de Pago</title>

  <!-- Ícono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Librerías de íconos y estilos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Formas_Pago_Admin.css">
</head>

<body>

  <!-- Barra de navegación de administrador -->
  <nav class="navigation">
    <a href="index.php?page=admin_home" class="logo">
        <img src="<?= BASE_URL ?>Image/Logo.jpg" alt="Dreams & Prints Logo">
        <span>Dreams & Prints</span>
    </a>
    <a href="index.php?page=admin_home"><i class="fas fa-home"></i> Inicio</a>
    <a href="index.php?page=catalogo_admin"><i class="fas fa-th-list"></i> Catálogo</a>
    <a href="index.php?page=compras_admin"><i class="fas fa-box-open"></i> Gestión de Compras</a>
    <a href="index.php?page=formasPagoAdmin" class="active"><i class="fas fa-credit-card"></i> Formas de Pago</a>
    <a href="index.php?page=ideaAdmin"><i class="fas fa-tools"></i> Administrar Ideas</a>
    <a href="index.php?page=acercaDeAdmin"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
    <a href="index.php?page=cuenta_admin"><i class="fas fa-user-shield"></i> Cuenta</a>
  </nav>

  <!-- Contenedor de métodos de pago -->
  <div class="payment-container">
    <div class="payment-header">
      <h1>Formas de Pago</h1>
    </div>

    <!-- Lista de métodos configurables (estáticos con opción a editar/eliminar) -->
    <div class="payment-methods">
      <h2>Opciones Disponibles:</h2>
      <ul id="paymentMethodsList">
        <li id="payment-method-1">
          <i class="fas fa-credit-card"></i> Tarjeta de Crédito o Débito (Visa, MasterCard, American Express)
          <button onclick="editPaymentMethod('payment-method-1')">Editar</button>
          <button onclick="deletePaymentMethod('payment-method-1')">Eliminar</button>
        </li>
        <li id="payment-method-2">
          <i class="fas fa-university"></i> Transferencia Bancaria (Contactos al por Whatsapp al 477-FER-0000)
          <button onclick="editPaymentMethod('payment-method-2')">Editar</button>
          <button onclick="deletePaymentMethod('payment-method-2')">Eliminar</button>
        </li>
        <li id="payment-method-3">
          <i class="fas fa-money-bill-wave"></i> Pago en Efectivo (Pagas al momento de entrega)
          <button onclick="editPaymentMethod('payment-method-3')">Editar</button>
          <button onclick="deletePaymentMethod('payment-method-3')">Eliminar</button>
        </li>
      </ul>

      <!-- Botón para agregar un nuevo método (visual) -->
      <button onclick="addPaymentMethod()">Agregar Método de Pago</button>
    </div>

    <!-- Tarjetas registradas por los clientes -->
    <div id="tarjetasGuardadas" class="payment-methods">
      <h2>Tarjetas Guardadas:</h2>
      <?php
      require_once __DIR__ . '/../../models/TarjetaCliente.php';
      $modelo = new TarjetaCliente();
      $tarjetas = $modelo->obtenerTodas();
      ?>
      <ul id="tarjetasList">
        <?php if ($tarjetas && count($tarjetas) > 0): ?>
          <?php foreach ($tarjetas as $t): ?>
            <li>
              <i class="fas fa-credit-card"></i>
              <strong><?= htmlspecialchars($t['nombreTitular']) ?></strong>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li>No se han registrado tarjetas.</li>
        <?php endif; ?>
      </ul>
    </div>
  </div>

  <!-- Pie de página -->
  <div class="footer">
    <p>&copy; 2024 Dreams & Prints. Todos los derechos reservados.</p>
    <p>Visita nuestra <a href="#">página principal</a>.</p>
  </div>

  <!-- Script para manejo de acciones de edición visual -->
  <script src="<?= BASE_URL ?>js/Formas_Pago_Admi_Nuevo.js"></script>

</body>
</html>
