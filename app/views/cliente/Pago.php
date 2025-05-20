<!DOCTYPE html>
<html class="carrito" lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>D&P: Pago</title>

  <!-- Ícono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Hoja de estilo para el formulario de pago -->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Pago_New.css" />
</head>

<body>

  <!-- Contenedor principal de la sección de pago -->
  <div class="grid align__item">
    <h2>Ingrese su información de pago a continuación</h2>

    <!-- Tarjeta con detalles del pedido y formulario -->
    <div id="metodo-tarjeta" class="card">
      <header class="card__header">
        <h3 class="card__title">Detalles del pago</h3>
      </header>

      <?php
      // Inicia sesión si aún no está iniciada
      if (session_status() === PHP_SESSION_NONE) session_start();

      // Recupera el carrito desde la sesión
      $carrito = $_SESSION['carrito'] ?? [];
      $total = 0; // Inicializa el total
      ?>

      <!-- Lista de productos en el carrito -->
      <ul style="margin: 1rem 0 0 1.5rem; list-style: disc;">
        <?php foreach ($carrito as $item): ?>
          <?php $total += $item['precio']; ?>
          <li style="margin-bottom: 0.4rem;">
            <strong><?= htmlspecialchars($item['producto']) ?></strong> –
            <?= htmlspecialchars($item['dimension']) ?>,
            <?= htmlspecialchars($item['material']) ?>,
            Color: <?= htmlspecialchars($item['color']) ?> –
            <span><strong>$<?= number_format($item['precio'], 2) ?></strong></span>
          </li>
        <?php endforeach; ?>
      </ul>

      <!-- Total a pagar -->
      <p class="total" style="margin: 1rem 0 2rem 1.5rem; font-weight: bold;">
        Total a pagar: $<?= number_format($total, 2) ?>
      </p>

      <!-- Formulario para seleccionar método de pago -->
      <form action="index.php?page=confirmar_pago" method="post" class="form">

        <!-- Selector de tipo de pago -->
        <label for="tipoPago">Selecciona tipo de pago:</label>
        <select name="tipoPago" id="tipoPago" onchange="mostrarMetodoPago()" required>
          <option value="Tarjeta">Tarjeta</option>
          <option value="Efectivo">Efectivo</option>
          <option value="Transferencia">Transferencia</option>
        </select>

        <!-- Información de tarjeta (mostrada si se selecciona 'Tarjeta') -->
        <div id="pago-tarjeta" class="pago-metodo">
          <div class="card__number form__field">
            <label for="card__number" class="card__number__label">Número de tarjeta</label>
            <input type="text" id="card__number" class="card__number__input" placeholder="1234 1234 1234 1234" />
          </div>

          <div class="card__expiration form__field">
            <label for="card__expiration__year">Expiración</label>
            <input type="month" id="card__expiration__date" class="card__expiration__input" placeholder="YYYY/MM" />
          </div>

          <div class="card__ccv form__field">
            <label for="">CCV</label>
            <input type="text" class="card__ccv__input" placeholder="583" />
          </div>
        </div>

        <!-- Información para pago en efectivo -->
        <div id="pago-efectivo" class="pago-metodo" style="display: none;">
          <p>Presenta este comprobante en nuestra tienda para realizar el pago.</p>
          <div id="codigo-barras" style="text-align: center; margin: 1rem 0;">
              <p><strong>Pago en OXXO</strong></p>
              <div style="
                font-family: monospace;
                font-size: 1.5rem;
                letter-spacing: 4px;
                border: 2px dashed #fff;
                padding: 10px 20px;
                display: inline-block;
                background-color: #111;
                color: #0f0;">
                <!-- Generador de número de referencia ficticio -->
                <?= rand(1000,9999) . ' ' . rand(1000,9999) . ' ' . rand(1000,9999) . ' ' . rand(1000,9999) ?>
              </div>
          </div>
        </div>

        <!-- Información para pago por transferencia -->
        <div id="pago-transferencia" class="pago-metodo" style="display: none;">
          <p>Realiza una transferencia a esta cuenta:</p>
          <ul>
            <li>Banco: EjemploBank</li>
            <li>CLABE: 012345678901234567</li>
            <li>Beneficiario: Dreams & Prints</li>
          </ul>
        </div>
        
        <!-- Botón para confirmar el pago -->
        <button type="submit" class="btn btn--primary">Confirmar pago</button>
      </form>
    </div>

  </div>

  <!-- Script de funciones para mostrar u ocultar secciones según tipo de pago -->
  <script src="<?= BASE_URL ?>js/Pago_New.js"></script>

</body>
</html>
