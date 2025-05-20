<?php
// Verifica que el usuario tenga una sesión activa como 'Cliente'
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
  <title>D&P: Cliente</title>

  <!-- Icono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Íconos y hojas de estilo -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Idea_Cliente_Admi.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Idea_Nuevo.css">
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
    <a href="index.php?page=formasPago"><i class="fas fa-credit-card"></i> Formas de Pago</a>
    <a href="index.php?page=idea" class="active"><i class="fas fa-lightbulb"></i> Ideas</a>
    <a href="index.php?page=acercaDe"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
    <a href="index.php?page=cuenta"><i class="fas fa-user-circle"></i> Cuenta</a>
  </nav>

  <!-- Contenido principal -->
  <div class="cliente-container">
    <h1>Bienvenido, Cliente</h1>

    <!-- Botones para abrir los modales -->
    <div class="botones-acciones">
      <button onclick="abrirModal('modalAgregar')">Agregar Idea</button>
      <button onclick="abrirModal('modalBuscar')">Buscar Idea</button>
    </div>

    <!-- Sección de ideas -->
    <section class="ideas-container" id="seccion-ideas">
      <h2>Ideas</h2>
      <div id="ideas-contenedor">
        <?php if (!empty($ideas)): ?>
          <?php foreach ($ideas as $idea): ?>
            <div class="idea-card">
              <!-- Imagen de la idea en formato base64 -->
              <img src="data:image/jpeg;base64,<?= base64_encode($idea['imagenIdea']) ?>" alt="Imagen de la idea">
              <div class="idea-info">
                <h3><?= htmlspecialchars($idea['titulo']) ?></h3>
                <p><strong>Categoría:</strong> <?= htmlspecialchars($idea['categoriaProducto']) ?></p>
                <p><?= nl2br(htmlspecialchars($idea['descripcion'])) ?></p>
                <p class="autor"><strong>Creado por:</strong> <?= htmlspecialchars($idea['nombreCliente']) ?></p>

                <!-- Solo el creador puede eliminar su idea -->
                <?php if ($_SESSION['idCliente'] == $idea['idCliente']): ?>
                  <button class="btn-eliminar" onclick="cargarIdEliminar(<?= $idea['idIdea'] ?>, '<?= htmlspecialchars($idea['titulo']) ?>')">Eliminar</button>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="text-align:center; color:#888; font-size:1rem;">No se encontraron ideas activas.</p>
        <?php endif; ?>
      </div>
    </section>

    <!-- Modal: Agregar Idea -->
    <div id="modalAgregar" class="modal">
      <div class="modal-content">
        <span class="cerrar-modal" onclick="cerrarModal('modalAgregar')">&times;</span>
        <h3>Agregar Idea</h3>
        <form action="index.php?page=agregar_idea" method="POST" enctype="multipart/form-data" class="form-agregar-idea">
          <label for="titulo">Título:</label>
          <input type="text" name="titulo" id="titulo" required>

          <label for="descripcion">Descripción:</label>
          <textarea name="descripcion" id="descripcion" rows="4" required></textarea>

          <label for="categoria">Categoría:</label>
          <input type="text" name="categoria" id="categoria" required>

          <label for="imagen">Imagen:</label>
          <input type="file" name="imagen" id="imagen" accept="image/*" required>

          <button type="submit" class="btn-agregar">Agregar</button>
        </form>
      </div>
    </div>

    <!-- Modal: Buscar Idea -->
    <div id="modalBuscar" class="modal">
      <div class="modal-content">
        <span class="cerrar-modal" onclick="cerrarModal('modalBuscar')">&times;</span>
        <h3>Buscar Idea</h3>
        <form action="index.php?page=buscar_idea" method="POST">
          <input type="text" name="busqueda" placeholder="Buscar por título o categoría" required>
          <button type="submit">Buscar</button>
        </form>
      </div>
    </div>

    <!-- Modal: Eliminar Idea -->
    <div id="modal-eliminar" class="modal">
      <div class="modal-content">
        <span class="cerrar-modal" onclick="cerrarModal('modal-eliminar')">&times;</span>
        <h2>¿Eliminar esta idea?</h2>
        <form action="index.php?page=eliminar_idea" method="POST">
          <input type="hidden" name="idIdea" id="input-id-idea">
          <p id="titulo-idea-a-eliminar"></p>
          <button type="submit">Confirmar eliminación</button>
        </form>
      </div>
    </div>

  </div>

  <!-- Script JS para manejo de modales e interacciones -->
  <script src="<?= BASE_URL ?>js/Idea_Nuevo.js"></script>

</body>
</html>
