<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Restablecer Contraseña</title>

  <!-- Hoja de estilo para recuperación -->
  <link rel="stylesheet" href="<?= BASE_URL ?>css/Estilo_Recuperacion.css">
</head>

<body>

  <!-- Contenedor principal del formulario de recuperación -->
  <div class="recovery-container">
    <h2>Restablecer Contraseña</h2>

    <!-- Mensaje de error si la URL contiene un parámetro ?error -->
    <?php if (isset($_GET['error'])): ?>
      <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>

    <!-- Formulario para guardar la nueva contraseña -->
    <form method="post" action="index.php?page=guardar_nueva_contrasena">

      <div class="input-group">
        <label for="nueva_contrasena">Nueva Contraseña:</label>
        <input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
      </div>

      <div class="input-group">
        <label for="confirmar_contrasena">Confirmar Contraseña:</label>
        <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
      </div>

      <button type="submit" class="send-button">Guardar Contraseña</button>
    </form>

    <!-- Botón para regresar a la página de inicio de sesión -->
    <button class="back-button" onclick="window.location.href='index.php?page=sesion'">Cancelar</button>
  </div>

</body>
</html>
