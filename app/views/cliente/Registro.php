<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D&P: Registro</title>

  <!-- Ícono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Estilos e íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/Estilo_Registro.css">
</head>

<body>

  <!-- Contenedor principal del formulario de registro -->
  <div class="register-container">
    <h2>Registro</h2>

    <!-- Formulario para registrar un nuevo cliente -->
    <form id="register-form" method="POST" action="index.php?page=registrar">
      <div class="input-group">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required>
      </div>

      <div class="input-group">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="input-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
      </div>

      <!-- Botón para enviar el formulario -->
      <button type="submit" class="register-button">Registrarse</button>
    </form>

    <!-- Opción para redirigir a inicio de sesión si ya tiene cuenta -->
    <div class="login">
      <p>¿Ya tienes una cuenta? <a href="index.php?page=sesion">Inicia sesión aquí</a></p>
    </div>

    <!-- Botón para volver al inicio -->
    <button class="back-button" onclick="window.location.href='index.php?page=sesion'">
      Volver a la página principal
    </button>
  </div>

</body>
</html>
