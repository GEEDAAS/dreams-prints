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
    <title>Consultar Clientes</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>Image/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>css/Estilo_Cuenta_Nuevo.css">
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f4f4f4;
    color: #333;
}

h2 {
    text-align: center;
    color: #ff6f61;
    margin-bottom: 20px;
}

form {
    text-align: center;
    margin-bottom: 20px;
}

input[type="text"] {
    padding: 10px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-right: 10px;
}

button {
    padding: 10px 20px;
    background-color: #ff6f61;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #ff6f61;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 0 auto;
    background-color: #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

th {
    background-color: #ff6f61;
    color: white;
}

a {
    color: #d32f2f;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
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
        <a href="index.php?page=ideaAdmin"><i class="fas fa-tools"></i> Administrar Ideas</a>
        <a href="index.php?page=acercaDeAdmin"><i class="fas fa-info-circle"></i> Acerca de</a>
        <a href="index.php?page=ConsultarCliente" class="active"><i class="fas fa-search"></i> Consultar Clientes</a>
        <a href="index.php?page=cerrar"><i class="fas fa-user"></i> Cierre Sesión</a>
        <a href="index.php?page=cuenta_admin"><i class="fas fa-user-shield"></i> Cuenta</a>
    </nav>

    <h2>Consultar Clientes</h2>
    <form method="POST" action="index.php?page=buscarCliente">
        <input type="text" name="termino" placeholder="Buscar por nombre o correo" required>
        <button type="submit">Buscar</button>
        <a href="index.php?page=ConsultarCliente" style="margin-left: 10px;"> Ver todos</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Tipo de Usuario</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= htmlspecialchars($cliente['nombreCliente']) ?></td>
                <td><?= htmlspecialchars($cliente['correoCliente']) ?></td>
                <td>
                    <?= isset($cliente['tipoUsuario']) ? 
                        ($cliente['tipoUsuario'] === 'Administrador' ? '<strong style="color:darkred;">Administrador</strong>' : 'Cliente') 
                        : 'Desconocido'; ?>
                </td>
                <td><?= isset($cliente['estadoCliente']) ? htmlspecialchars($cliente['estadoCliente']) : 'Sin estado' ?></td>
                <td>
                    <?php if (isset($cliente['tipoUsuario']) && $cliente['tipoUsuario'] !== 'Administrador'): ?>
                        <a href="index.php?page=darDeBajaCliente&id=<?= $cliente['idCliente'] ?>"
                        onclick="return confirm('¿Deseas dar de baja a este cliente?')">
                            <i class="fas fa-user-slash"></i> Dar de baja
                        </a>
                    <?php else: ?>
                        <span style="color: gray;"><i class="fas fa-ban"></i> No disponible</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
