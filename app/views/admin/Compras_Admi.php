<?php
// Verifica que el usuario tenga rol de 'Administrador'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: index.php?page=sesion");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>D&P: Compras Admin</title>

  <!-- Ícono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Librerías e íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/Estilo_Compras_Admi.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/Estilo_Catalogo_Admi.css">
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
    <a href="index.php?page=compras_admin" class="active"><i class="fas fa-box-open"></i> Gestión de Compras</a>
    <a href="index.php?page=formasPagoAdmin"><i class="fas fa-credit-card"></i> Formas de Pago</a>
    <a href="index.php?page=ideaAdmin"><i class="fas fa-tools"></i> Administrar Ideas</a>
    <a href="index.php?page=acercaDeAdmin"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="index.php?page=ConsultarCliente"><i class="fas fa-search"></i> Consultar Clientes</a>
    <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
    <a href="index.php?page=cuenta_admin"><i class="fas fa-user-shield"></i> Cuenta</a>
  </nav>

  <h2 style="text-align:center; margin: 1.5rem 0;">Panel de Compras</h2>

  <!-- Contenedor de tarjetas de compras -->
  <div class="compras-container">
    <?php foreach ($compras as $compra): ?>
      <div class="card-compra">
        <!-- Información general de la compra -->
        <div class="compra-header">
          <strong>Compra #<?= $compra['idCompra'] ?></strong>
          <span class="fecha"><?= $compra['fechaCompra'] ?></span>
        </div>

        <p><strong>Cliente:</strong> <?= $compra['cliente']['nombreCliente'] ?></p>
        <p><strong>Total:</strong> $<?= number_format($compra['montoTotal'], 2) ?></p>
        <p><strong>Tipo de pago:</strong> <?= $compra['pago']['tipoPago'] ?></p>

        <p><strong>Estado de compra:</strong>
          <span class="estado <?= strtolower($compra['estadoCompra']) ?>">
            <?= $compra['estadoCompra'] ?>
          </span>
        </p>

        <p><strong>Estado de pago:</strong>
          <span class="estado <?= strtolower($compra['pago']['estadoPago']) ?>">
            <?= $compra['pago']['estadoPago'] ?>
          </span>
        </p>

        <!-- Formulario para cambiar el estado de pago -->
        <form class="form-estado-pago" data-id="<?= $compra['idCompra'] ?>">
          <label for="estadoPago">Cambiar estado de pago:</label>
          <select name="estadoPago" class="dropdown-estado-pago">
            <option <?= $compra['pago']['estadoPago'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
            <option <?= $compra['pago']['estadoPago'] === 'Aprobado' ? 'selected' : '' ?>>Aprobado</option>
            <option <?= $compra['pago']['estadoPago'] === 'Rechazado' ? 'selected' : '' ?>>Rechazado</option>
          </select>
        </form>

        <!-- Lista de productos asociados a la compra -->
        <div class="productos-lista">
          <strong>Productos:</strong>
          <ul>
            <?php foreach ($compra['impresiones'] as $item): 
              $config = json_decode($item['configuracion'], true); ?>
              <li>
                <?= $config['producto'] ?> – <?= $config['dimension'] ?>, <?= $config['material'] ?>, Color: <?= $config['color'] ?><br>
                <span class="estado <?= strtolower($item['estadoImpresion']) ?>">
                  <?= $item['estadoImpresion'] ?>
                </span>

                <!-- Formulario para cambiar el estado de impresión -->
                <form class="form-estado-impresion" 
                      data-id="<?= $item['idImpresion'] ?>" 
                      data-idcompra="<?= $compra['idCompra'] ?>">
                  
                  <label for="estadoImpresion">Cambiar estado de impresión:</label>
                  <select name="estadoImpresion" class="dropdown-estado-impresion"
                          <?= $compra['pago']['estadoPago'] !== 'Aprobado' ? 'disabled' : '' ?>>
                    <option <?= $item['estadoImpresion'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option <?= $item['estadoImpresion'] === 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                    <option <?= $item['estadoImpresion'] === 'Completada' ? 'selected' : '' ?>>Completada</option>
                    <option <?= $item['estadoImpresion'] === 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                  </select>

                  <?php if ($compra['pago']['estadoPago'] !== 'Aprobado'): ?>
                    <p style="color: #999; font-size: 0.85rem;">
                      Disponible solo cuando el pago esté aprobado
                    </p>
                  <?php endif; ?>
                </form>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Script que maneja los eventos dinámicos -->
  <script src="<?= BASE_URL ?>js/Compras_Admi.js"></script>
</body>
</html>
