<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D&P: Inicio de Sesión</title>

  <!-- Ícono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Librerías de estilo -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Sesion.css">
</head>

<body>

  <!-- Contenedor principal del formulario de login -->
  <div class="login-container">
    <h2>Inicio de Sesión</h2>

    <!-- Formulario para autenticar al usuario -->
    <form id="login-form" method="POST" action="index.php?page=validar">
      <div class="input-group">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="input-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
      </div>

      <button type="submit" class="login-button">Ingresar</button>
    </form>

    <!-- Enlace para recuperar contraseña -->
    <div class="forgot-password">
      <a href="index.php?page=recuperar">¿Olvidaste tu contraseña?</a>
    </div>

    <!-- Enlace a la página de registro -->
    <div class="register">
      <p>¿No tienes una cuenta? <a href="index.php?page=registro">Regístrate aquí</a></p>
    </div>
  </div>

</body>
</html>
