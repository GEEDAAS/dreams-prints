<?php
// Verifica que el usuario esté autenticado y sea un cliente
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Cliente') {
    header("Location: index.php?page=sesion");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>D&P: Historial de Compras</title>

    <!-- Íconos y estilos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/Estilo_Historial.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/Estilo_Formas_Pago.css">
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
      <a href="index.php?page=historial" class="active"><i class="fas fa-receipt"></i> Historial</a>
      <a href="index.php?page=formasPago"><i class="fas fa-credit-card"></i> Formas de Pago</a>
      <a href="index.php?page=idea"><i class="fas fa-lightbulb"></i> Ideas</a>
      <a href="index.php?page=acercaDe"><i class="fas fa-info-circle"></i> Acerca de</a>
      <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
      <a href="index.php?page=cuenta"><i class="fas fa-user-circle"></i> Cuenta</a>
    </nav>

    <!-- Título -->
    <h2 style="text-align: center; margin: 2rem 0;">Historial de Compras</h2>

    <!-- Contenedor principal del historial -->
    <div class="historial-container">
        <?php if (!empty($compras)): ?>
            <?php foreach ($compras as $compra): ?>
                <div class="card-compra">
                    <!-- Encabezado con número de compra y fecha -->
                    <div class="card-header">
                        <strong>Compra #<?= $compra['idCompra'] ?></strong>
                        <span class="fecha"><?= $compra['fechaCompra'] ?></span>
                    </div>

                    <!-- Detalles generales -->
                    <p><strong>Total:</strong> $<?= number_format($compra['montoTotal'], 2) ?></p>
                    <p><strong>Estado de compra:</strong> 
                        <span class="estado <?= strtolower($compra['estadoCompra']) ?>">
                        <?= $compra['estadoCompra'] ?>
                        </span>
                    </p>
                    <p><strong>Tipo de pago:</strong> <?= $compra['pago']['tipoPago'] ?></p>

                    <?php if (isset($compra['pago'])): ?>
                    <p><strong>Estado de pago:</strong>
                        <span class="estado <?= strtolower($compra['pago']['estadoPago']) ?>">
                        <?= $compra['pago']['estadoPago'] ?>
                        </span>
                    </p>
                    <?php endif; ?>

                    <!-- Lista de productos configurados -->
                    <div>
                        <strong>Productos:</strong>
                        <ul class="productos">
                            <?php foreach ($compra['impresiones'] as $impresion): 
                                $config = json_decode($impresion['configuracion'], true); ?>
                                
                                <li>
                                  <?= $config['producto'] ?> – <?= $config['dimension'] ?>,
                                  <?= $config['material'] ?>, Color: <?= $config['color'] ?><br>

                                  <span class="estado <?= strtolower(str_replace(' ', '-', $impresion['estadoImpresion'])) ?>">
                                      <?= $impresion['estadoImpresion'] ?>
                                  </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Si no hay compras aún -->
            <p style="text-align: center;">Aún no has realizado ninguna compra.</p>
        <?php endif; ?>
    </div>
</body>
</html>
