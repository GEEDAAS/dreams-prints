<?php
// Inicia sesión si aún no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Verifica si el cliente está autenticado
if (!isset($_SESSION['idCliente'])) {
    header("Location: index.php?page=sesion"); // Redirige a inicio de sesión si no está autenticado
    exit();
}

// Verifica que el usuario tenga el rol correcto
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Cliente') {
    header("Location: index.php?page=sesion"); // Redirige si no tiene el rol 'Cliente'
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D&P: Cuenta</title>

  <!-- Icono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Íconos y estilos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Cuenta_Nuevo.css">
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
    <a href="index.php?page=idea"><i class="fas fa-lightbulb"></i> Ideas</a>
    <a href="index.php?page=acercaDe"><i class="fas fa-info-circle"></i> Acerca de</a>
    <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
    <a href="index.php?page=cuenta" class="active"><i class="fas fa-user-circle"></i> Cuenta</a>
  </nav>

  <!-- Contenido principal del perfil -->
  <main class="content">
    <section class="perfil-usuario">
      <div class="imagen-perfil">
        <?php if (!empty($datosCliente['imagenPerfil'])): ?>
          <!-- Imagen de perfil del cliente si está disponible -->
          <img src="data:image/jpeg;base64,<?= base64_encode($datosCliente['imagenPerfil']) ?>" alt="Imagen de perfil" />
        <?php else: ?>
          <!-- Imagen por defecto si no hay imagen de perfil -->
          <img src="<?= BASE_URL ?>Image/default_user.png" alt="Imagen por defecto" />
        <?php endif; ?>
      </div>
      <h2><?= htmlspecialchars($datosCliente['nombreCliente']) ?></h2>
      <p><?= htmlspecialchars($datosCliente['correoCliente']) ?></p>
      <p><strong>Rol:</strong> <?= htmlspecialchars($datosCliente['tipoUsuario']) ?></p>

      <!-- Botones para abrir los modales -->
      <div class="botones-perfil">
        <button onclick="openModal('updateModal')">Actualizar datos</button>
        <button onclick="openModal('passwordModal')">Modificar contraseña</button>
        <button onclick="openModal('deleteModal')">Eliminar cuenta</button>
      </div>
    </section>

    <!-- Modal: Actualizar datos -->
    <div id="updateModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal('updateModal')">&times;</span>
        <h3>Actualizar datos</h3>
        <form action="index.php?page=actualizar_datos" method="POST" enctype="multipart/form-data">
          <label for="nombre">Nombre:</label>
          <input type="text" name="nombre" value="<?= htmlspecialchars($datosCliente['nombreCliente']) ?>" required>

          <label for="correo">Correo:</label>
          <input type="email" name="correo" value="<?= htmlspecialchars($datosCliente['correoCliente']) ?>" required>

          <label for="imagenPerfil">Imagen de perfil:</label>
          <input type="file" name="imagenPerfil" accept="image/*">

          <button type="submit">Guardar Cambios</button>
        </form>
      </div>
    </div>

    <!-- Modal: Cambiar contraseña -->
    <div id="passwordModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal('passwordModal')">&times;</span>
        <h3>Modificar contraseña</h3>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alerta-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <form action="index.php?page=cambiar_contrasena" method="POST">
          <label for="nuevaClave">Nueva contraseña:</label>
          <input type="password" name="nuevaClave" required>

          <label for="confirmarClave">Confirmar contraseña:</label>
          <input type="password" name="confirmarClave" required>

          <button type="submit">Actualizar Contraseña</button>
        </form>
      </div>
    </div>

    <!-- Modal: Eliminar cuenta -->
    <div id="deleteModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal('deleteModal')">&times;</span>
        <h3>¿Estás seguro que deseas eliminar tu cuenta?</h3>
        <form action="index.php?page=eliminar_cuenta" method="POST">
          <button type="submit" class="btn-danger">Sí, eliminar</button>
        </form>
      </div>
    </div>
  </main>

  <!-- JavaScript para interacciones con los modales -->
  <script src="<?= BASE_URL ?>js/Cuenta.js"></script>
</body>

</html>
