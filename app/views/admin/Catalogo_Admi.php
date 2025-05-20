<?php
// Verifica si el usuario tiene el rol de 'Administrador'
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
  <title>D&P: Catálogo</title>

  <!-- Ícono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Íconos y hojas de estilo para administrador -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/Estilo_Catalogo_Admi.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/Estilo_Catalago_Admi_2.css">
</head>

<body>

  <!-- Barra de navegación del administrador -->
  <nav class="navigation">
    <a href="index.php?page=admin_home" class="logo">
      <img src="<?= BASE_URL ?>Image/Logo.jpg" alt="Dreams & Prints Logo">
      <span>Dreams & Prints</span>
    </a>
    <a href="index.php?page=admin_home"><i class="fas fa-home"></i> Inicio</a>
    <a href="index.php?page=catalogo_admin" class="active"><i class="fas fa-th-list"></i> Catálogo</a>
    <a href="index.php?page=compras_admin"><i class="fas fa-box-open"></i> Gestión de Compras</a>
    <a href="index.php?page=formasPagoAdmin"><i class="fas fa-credit-card"></i> Formas de Pago</a>
    <a href="index.php?page=ideaAdmin"><i class="fas fa-tools"></i> Administrar Ideas</a>
    <a href="index.php?page=acercaDeAdmin"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
    <a href="index.php?page=cuenta_admin"><i class="fas fa-user-shield"></i> Cuenta</a>
  </nav>

  <!-- Botón para abrir el modal de agregar producto -->
  <div class="admin-container">
    <div class="botones-acciones">
      <button onclick="abrirModal('modalAgregar')">Agregar Producto</button>
    </div>
  </div>

  <!-- Lista de productos -->
  <main class="catalog-list" id="catalog-list">
    <?php foreach ($productos as $prod): ?>
      <div class="catalog-item">
        <?php
          $imgBase64 = base64_encode($prod['imagenProducto']);
          $mime = "image/jpeg"; // Se asume formato JPEG
        ?>
        <img alt="<?= $prod['nombreProducto'] ?>" src="data:<?= $mime ?>;base64,<?= $imgBase64 ?>" />
        <div class="catalog-info">
          <h2><?= htmlspecialchars($prod['nombreProducto']) ?></h2>
          <p><?= htmlspecialchars($prod['descripcionProducto']) ?></p>
          <p><strong>Precio base:</strong> $<?= number_format($prod['precioProducto'], 2) ?></p>
          <p><strong>Stock:</strong> <?= $prod['cantidadProductoStock'] ?> unidades</p>
          <p><strong>Categoría:</strong> <?= htmlspecialchars($prod['categoriaProducto']) ?></p>

          <!-- Formulario para eliminar producto -->
          <form method="POST" action="index.php?page=eliminar_producto" style="display:inline;">
            <input type="hidden" name="id" value="<?= $prod['idProducto'] ?>">
            <button class="btn-eliminar" type="submit" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</button>
          </form>

          <!-- Botón para editar producto, con atributos data-* -->
          <button class="btn-editar"
            data-id="<?= $prod['idProducto'] ?>"
            data-nombre="<?= $prod['nombreProducto'] ?>"
            data-descripcion="<?= $prod['descripcionProducto'] ?>"
            data-precio="<?= $prod['precioProducto'] ?>"
            data-categoria="<?= $prod['categoriaProducto'] ?>"
            data-stock="<?= $prod['cantidadProductoStock'] ?>">
            Editar
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  </main>

  <!-- Modal para agregar producto -->
  <div id="modalAgregar" class="modal">
    <div class="modal-content">
      <span class="cerrar-modal" onclick="cerrarModal('modalAgregar')">&times;</span>
      <h3>Agregar Producto</h3>
      <form id="formAgregarProducto" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required></textarea>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" required>

        <label for="categoria">Categoría:</label>
        <input type="text" name="categoria" id="categoria" required>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" required>

        <select name="estado">
          <option value="Disponible">Disponible</option>
          <option value="No Disponible">No Disponible</option>
        </select>

        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*">

        <button type="submit">Agregar</button>
      </form>
    </div>
  </div>

  <!-- Modal para editar producto -->
  <div class="modal" id="modalEditarProducto" style="display: none;">
    <div class="modal-content">
      <span class="cerrar-modal" onclick="cerrarModal('modalEditarProducto')">&times;</span>
      <h3>Editar Producto</h3>
      <form id="formEditarProducto">
        <input type="hidden" id="edit-idProducto" name="idProducto">

        <label for="edit-nombre">Nombre:</label>
        <input type="text" id="edit-nombre" name="nombre" required>

        <label for="edit-descripcion">Descripción:</label>
        <textarea id="edit-descripcion" name="descripcion" required></textarea>

        <label for="edit-precio">Precio:</label>
        <input type="number" id="edit-precio" name="precio" min="1" required>

        <label for="edit-categoria">Categoría:</label>
        <input type="text" id="edit-categoria" name="categoria" required>

        <label for="edit-stock">Stock:</label>
        <input type="number" id="edit-stock" name="stock" min="0" required>

        <button type="submit" class="btn">Guardar Cambios</button>
      </form>
    </div>
  </div>

  <!-- Script que gestiona el catálogo (modales, edición, AJAX, etc.) -->
  <script src="<?= BASE_URL ?>js/New_Catalogo_Admi.js"></script>
</body>
</html>
