<?php
// Verifica que el usuario tenga el rol 'Cliente' antes de acceder al catálogo
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Cliente') {
    header("Location: index.php?page=sesion");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>D&P: Catálogo</title>

  <!-- Icono del sitio -->
  <link href="<?= BASE_URL ?>Image/favicon.ico" rel="icon" type="image/x-icon" />

  <!-- Estilos e íconos -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
  <link href="<?= BASE_URL ?>css/Estilo_Catalogo_Nuevo.css" rel="stylesheet" type="text/css" />
  <link href="<?= BASE_URL ?>css/Estilo_Conf_Piezas.css" rel="stylesheet" type="text/css" />
  <link href="<?= BASE_URL ?>css/Estilo_Catalogo2.css" rel="stylesheet" type="text/css" />
</head>

<body>

  <!-- Ícono flotante del carrito de compras -->
  <div id="carrito-toggle" onclick="toggleCarrito()">
    <i class="fas fa-shopping-cart"></i> <span id="carrito-count">0</span>
  </div>

  <!-- Barra de navegación -->
  <nav class="navigation">
    <a href="index.php?page=inicio" class="logo">
      <img src="<?= BASE_URL ?>Image/Logo.jpg" alt="Dreams & Prints Logo">
      <span>Dreams & Prints</span>
    </a>
    <a href="index.php?page=inicio"><i class="fas fa-home"></i> Inicio</a>
    <a href="index.php?page=catalogo" class="active"><i class="fas fa-th-list"></i> Catálogo</a>
    <a href="index.php?page=historial"><i class="fas fa-receipt"></i> Historial</a>
    <a href="index.php?page=formasPago"><i class="fas fa-credit-card"></i> Formas de Pago</a>
    <a href="index.php?page=idea"><i class="fas fa-lightbulb"></i> Ideas</a>
    <a href="index.php?page=acercaDe"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
    <a href="index.php?page=cuenta"><i class="fas fa-user-circle"></i> Cuenta</a>
  </nav>

  <!-- Formulario de filtros para buscar productos -->
  <div class="filtro">
    <form method="GET" action="index.php" class="filtro-form">
      <input type="hidden" name="page" value="catalogo">
      <input type="text" name="nombre" placeholder="Buscar por nombre" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
      <input type="text" name="categoria" placeholder="Filtrar por categoría" value="<?= htmlspecialchars($_GET['categoria'] ?? '') ?>">
      <button type="submit">Filtrar</button>
      <a href="index.php?page=catalogo" style="margin-left: 10px;">Ver Todo</a>
    </form>
  </div>

  <!-- Sección principal del catálogo -->
  <main class="catalog-list">
    <?php if (count($productos) > 0): ?>
      <?php foreach ($productos as $prod): ?>
        <div class="catalog-item">
          <?php
            // Se codifica la imagen en base64 para mostrarla directamente
            $imgBase64 = base64_encode($prod['imagenProducto']);
            $mime = "image/jpeg"; // Tipo de imagen (puede ajustarse)
          ?>
          <img alt="<?= $prod['nombreProducto'] ?>" src="data:<?= $mime ?>;base64,<?= $imgBase64 ?>" />
          <div class="catalog-info">
            <h2><?= htmlspecialchars($prod['nombreProducto']) ?></h2>
            <p><?= htmlspecialchars($prod['descripcionProducto']) ?></p>
            <p><strong>Precio base:</strong> $<?= number_format($prod['precioProducto'], 2) ?> <span style="font-size: 0.9em; color: #888;">+ su configuración</span></p>
            <p><strong>Stock:</strong> <?= $prod['cantidadProductoStock'] ?> unidades</p>
            <p><strong>Categoría:</strong> <?= htmlspecialchars($prod['categoriaProducto']) ?></p>
            <button class="btn-configurar" onclick="abrirConfiguracion('<?= $prod['nombreProducto'] ?>')">Configurar Producto</button>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align: center; font-size: 1.2em; color: #555; margin-top: 2rem;">
        No se encontraron resultados para tu búsqueda.
      </p>
    <?php endif; ?>
  </main>

  <!-- Carrito de compras flotante -->
  <div class="carrito oculto" id="carrito">
    <h3>Carrito de Compras</h3>
    <ul id="listaCarrito"></ul>
    <p>Total: $<span id="totalCarrito">0</span></p>
    <button onclick="window.location.href='index.php?page=pago'">Pagar</button>
    <button onclick="vaciarCarrito()" style="margin-left: 10px;">Vaciar</button>
  </div>

  <!-- Modal de configuración de producto -->
  <div class="modal" id="configModal">
    <div class="modal-content">
      <span class="close" onclick="cerrarConfiguracion()">×</span>
      <div class="config-container">
        <div class="config-header">
          <h1>Configuración de Piezas</h1>
          <p>Personaliza tus piezas según tus necesidades.</p>
        </div>
        <form class="config-form">
          <label for="producto">Producto:</label>
          <select id="producto" name="producto" onchange="actualizarPrecio()">
            <option value="">Seleccione un producto</option>
            <?php foreach ($productos as $producto): ?>
              <option 
                value="<?= $producto['nombreProducto'] ?>" 
                data-precio="<?= $producto['precioProducto'] ?>">
                <?= $producto['nombreProducto'] ?>
              </option>
            <?php endforeach; ?>
          </select>

          <label for="dimension">Dimensiones:</label>
          <select id="dimension" name="dimension" onchange="actualizarPrecio()">
            <option value="">Seleccione una dimensión</option>
            <option data-precio="10" value="10x10 cm">10x10 cm</option>
            <option data-precio="20" value="15x15 cm">15x15 cm</option>
          </select>

          <label for="material">Material:</label>
          <select id="material" name="material" onchange="actualizarPrecio()">
            <option value="">Seleccione un material</option>
            <option data-precio="5" value="plastico">Plástico</option>
            <option data-precio="15" value="metal">Metal</option>
          </select>

          <label for="color">Color:</label>
          <input id="color" name="color" placeholder="Ej. Rojo" type="text" />

          <p id="precio">Precio: $0.00</p>

          <button onclick="guardarConfiguracion()" type="button">Agregar al carrito</button>
        </form>
      </div>
    </div>
  </div>

  <!-- JavaScript para funcionalidades del catálogo -->
  <script src="<?= BASE_URL ?>js/Catalogo_Nuevo.js"></script>
</body>

</html>
