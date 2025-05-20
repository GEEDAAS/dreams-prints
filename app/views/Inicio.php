<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dreams & Prints - Bienvenido</title>

  <!-- Hoja de estilo personalizada para la portada -->
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Inicio_Nuevo.css">

  <!-- Ícono del sitio -->
  <link rel="icon" href="<?= BASE_URL ?>Image/favicon.ico" type="image/x-icon">
</head>

<body>

  <!-- Encabezado con logo y botones de navegación -->
  <header class="menu">
    <div class="logo">
      <img src="<?= BASE_URL ?>Image/Logo.jpg" alt="Dreams & Prints Logo">
      <span>Dreams & Prints</span>
    </div>
    <nav class="nav">
      <div class="nav-botones">
        <!-- Enlace a registro -->
        <a href="index.php?page=registro" class="btn-registrarse">Regístrate</a>
        <!-- Enlace a inicio de sesión -->
        <a href="index.php?page=sesion" class="btn-ingresar">Iniciar sesión</a>
      </div>
    </nav>
  </header>

  <!-- Cuerpo principal del sitio con diseño atractivo -->
  <main class="fondo-degradado">
    <div class="contenido-central">
      <h1>Ideas que cobran vida.</h1>
      <p>Personaliza, imprime y haz realidad tus sueños en 3D.</p>
      <!-- Botón principal que redirige a iniciar sesión -->
      <button class="btn-principal" onclick="window.location.href='index.php?page=sesion'">
        Empezar ahora
      </button>
    </div>

    <!-- Elementos decorativos del fondo -->
    <div class="decoracion-coral">
      <div class="figura figura1"></div>
      <div class="figura figura2"></div>
      <div class="figura figura3"></div>
      <div class="figura figura4"></div>
    </div>
  </main>

</body>
</html>
