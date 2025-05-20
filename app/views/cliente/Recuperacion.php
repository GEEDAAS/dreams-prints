<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D&P: Recuperación de Cuenta</title>

  <!-- Ícono del sitio -->
  <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">

  <!-- Librerías externas -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Correo_Nuevo.css">

  <!-- EmailJS para envío de correos -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
</head>

<body>

  <!-- Contenedor principal -->
  <div class="recovery-container">
    <h2>Recuperación de Cuenta</h2>

    <!-- Formulario para solicitar envío del código de recuperación -->
    <form id="recovery-form">
      <div class="input-group">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <button type="button" class="send-button" onclick="sendRecoveryCode()">Enviar Código</button>
    </form>

    <!-- Sección que se muestra al enviar el código -->
    <div id="codigo-section" style="display:none;">
      <label for="codigo">Ingresa el código de recuperación:</label>
      <input type="text" id="codigo" name="codigo" required>
      <button onclick="validarCodigo()">Validar Código</button>
    </div>

    <!-- Botón para regresar a la vista de sesión -->
    <button class="back-button" onclick="window.location.href='index.php?page=sesion'">
      Volver a la página principal
    </button>
  </div>

  <!-- JavaScript que controla el envío del correo y validación -->
  <script src="<?= BASE_URL ?>js/Correo.js"></script>

</body>
</html>
