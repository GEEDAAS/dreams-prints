<?php
// Verifica que el usuario tenga el rol de 'Administrador'
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
  <title>D&P: Administrador</title>

  <!-- Ícono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Librerías de íconos y estilos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Idea_Cliente_Admi.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Idea_Admi_Nuevo.css">
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
    <a href="index.php?page=ideaAdmin" class="active"><i class="fas fa-tools"></i> Administrar Ideas</a>
    <a href="index.php?page=acercaDeAdmin"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="index.php?page=ConsultarCliente"><i class="fas fa-search"></i> Consultar Clientes</a>
    <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
    <a href="index.php?page=cuenta_admin"><i class="fas fa-user-shield"></i> Cuenta</a>
  </nav>

  <!-- Contenedor principal -->
  <div class="admin-container">
    <h1>Bienvenido, Administrador</h1>

    <!-- Botón para abrir el modal de búsqueda -->
    <div class="botones-acciones">
      <button onclick="abrirModal('modalBuscar')">Buscar Idea</button>
    </div>

    <!-- Sección de ideas del sistema -->
    <section class="ideas-container" id="seccion-ideas">
      <h2>Ideas</h2>
      <div id="ideas-contenedor">
        <?php if (!empty($ideas)): ?>
          <?php foreach ($ideas as $idea): ?>
            <div class="idea-card">
              <!-- Imagen en base64 -->
              <img src="data:image/jpeg;base64,<?= base64_encode($idea['imagenIdea']) ?>" alt="Imagen de la idea">
              <div class="idea-info">
                <h3><?= htmlspecialchars($idea['titulo']) ?></h3>
                <p><strong>Categoría:</strong> <?= htmlspecialchars($idea['categoriaProducto']) ?></p>
                <p><?= nl2br(htmlspecialchars($idea['descripcion'])) ?></p>
                <p><strong>Estado:</strong> <?= $idea['estadoIdea'] ?></p>
                <p><strong>Cliente:</strong> <?= htmlspecialchars($idea['nombreCliente']) ?></p>

                <!-- Formulario para eliminar o reactivar según estado -->
                <?php if ($idea['estadoIdea'] === 'Activa'): ?>
                  <form method="POST" action="index.php?page=eliminar_idea_admi">
                    <input type="hidden" name="idIdea" value="<?= $idea['idIdea'] ?>">
                    <button class="btn-eliminar" type="submit">Eliminar</button>
                  </form>
                <?php else: ?>
                  <form method="POST" action="index.php?page=activar_idea_admi">
                    <input type="hidden" name="idIdea" value="<?= $idea['idIdea'] ?>">
                    <button class="btn-reactivar" type="submit">Reactivar</button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="text-align: center; color: #666;">No se encontraron ideas.</p>
        <?php endif; ?>
      </div>
    </section>

    <!-- Modal de búsqueda de ideas -->
    <div id="modalBuscar" class="modal">
      <div class="modal-content">
        <span class="cerrar-modal" onclick="cerrarModal('modalBuscar')">&times;</span>
        <h3>Buscar Idea</h3>
        <form action="index.php?page=buscar_idea_admi" method="POST">
          <input type="text" name="busqueda" placeholder="Buscar por título o categoría" required>
          <button type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Script JS para manejar modales y búsqueda -->
  <script src="<?= BASE_URL ?>js/Idea_Admi.js"></script>
</body>
</html>
