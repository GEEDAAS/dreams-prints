<?php

// Activa el sistema de enrutamiento basado en un parámetro GET llamado 'page'
$page = $_GET['page'] ?? 'PageHome'; // Si no se proporciona, carga la página principal por defecto

switch ($page) {
    // Página principal del sistema
    case 'PageHome':
        require '../app/controllers/InicioController.php';
        $controller = new InicioController();
        $controller->index();
        break;

    // Vista pública de inicio
    case 'inicio':
        require '../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    // Página principal del administrador
    case 'admin_home':
        require '../app/views/admin/Principal_Admi.php';
        break;

    // Módulo de cuenta del cliente
    case 'cuenta':
        require '../app/controllers/CuentaController.php';
        $controller = new CuentaController();
        $controller->cuenta();
        break;

    case 'actualizar_datos':
        require '../app/controllers/CuentaController.php';
        $controller = new CuentaController();
        $controller->actualizarDatos();
        break;

    case 'cambiar_contrasena':
        require '../app/controllers/CuentaController.php';
        $controller = new CuentaController();
        $controller->cambiarContrasena();
        break;

    case 'eliminar_cuenta':
        require '../app/controllers/CuentaController.php';
        $controller = new CuentaController();
        $controller->eliminarCuenta();
        break;

    // Módulo de cuenta del administrador
    case 'cuenta_admin':
        require '../app/controllers/CuentaAdmiController.php';
        $controller = new CuentaAdmiController();
        $controller->cuentaAdmi();
        break;

    case 'actualizar_datos_admi':
        require '../app/controllers/CuentaAdmiController.php';
        $controller = new CuentaAdmiController();
        $controller->actualizarDatos();
        break;

    case 'cambiar_contrasena_admi':
        require '../app/controllers/CuentaAdmiController.php';
        $controller = new CuentaAdmiController();
        $controller->cambiarContrasena();
        break;

    case 'eliminar_cuenta_admi':
        require '../app/controllers/CuentaAdmiController.php';
        $controller = new CuentaAdmiController();
        $controller->eliminarCuenta();
        break;

    // Catálogo del cliente
    case 'catalogo':
        require '../app/controllers/CatalogoController.php';
        $controller = new CatalogoController();
        $controller->index();
        break;

    // Carrito de compras
    case 'agregar_carrito':
        require '../app/controllers/CarritoController.php';
        $controller = new CarritoController();
        $controller->agregar();
        break;

    case 'eliminar_carrito':
        require '../app/controllers/CarritoController.php';
        $controller = new CarritoController();
        $controller->eliminar();
        break;

    case 'vaciar_carrito':
        require '../app/controllers/CarritoController.php';
        $controller = new CarritoController();
        $controller->vaciar();
        break;

    case 'mostrar_carrito':
        require '../app/controllers/CarritoController.php';
        $controller = new CarritoController();
        $controller->mostrar();
        break;

    // Catálogo para el administrador
    case 'catalogo_admin':
        require '../app/controllers/CatalogoAdminController.php';
        $controller = new CatalogoAdminController();
        $controller->index();
        break;

    // Gestión de compras por el administrador
    case 'compras_admin':
        require_once '../app/controllers/AdminComprasController.php';
        $controller = new AdminComprasController();
        $controller->index();
        break;

    case 'actualizar_estado_pago':
        require_once '../app/controllers/AdminComprasController.php';
        (new AdminComprasController())->actualizarEstadoPago();
        break;

    case 'actualizar_estado_impresion':
        require_once '../app/controllers/AdminComprasController.php';
        (new AdminComprasController())->actualizarEstadoImpresion();
        break;

    // Gestión de productos por el administrador
    case 'agregar_producto':
        require '../app/controllers/CatalogoAdminController.php';
        $controller = new CatalogoAdminController();
        $controller->agregar();
        break;

    case 'actualizar_producto':
        require_once '../app/controllers/CatalogoAdminController.php';
        $controller = new CatalogoAdminController();
        $controller->actualizarProducto();
        break;

    case 'eliminar_producto':
        require '../app/controllers/CatalogoAdminController.php';
        $controller = new CatalogoAdminController();
        $controller->eliminar();
        break;

    // Módulo de formas de pago para cliente
    case 'formasPago':
        require '../app/controllers/FormasPagoController.php';
        $controller = new FormasPagoController();
        $controller->index();
        break;

    case 'guardar_tarjeta':
        require '../app/controllers/FormasPagoController.php';
        $controller = new FormasPagoController();
        $controller->guardar_tarjeta();
        break;

    // Módulo de formas de pago para administrador
    case 'formasPagoAdmin':
        require '../app/controllers/FormasPagoAdminController.php';
        $controller = new FormasPagoAdminController();
        $controller->index();
        break;

    // Página informativa
    case 'acercaDe':
        require '../app/controllers/AcercaDeController.php';
        $controller = new AcercaDeController();
        $controller->index();
        break;

    case 'acercaDeAdmin':
        require '../app/controllers/AcercaDeController.php';
        $controller = new AcercaDeController();
        $controller->indexAdmin();
        break;

    // Registro de clientes
    case 'registro':
        require '../app/controllers/RegistroController.php';
        $controller = new RegistroController();
        $controller->index();
        break;

    case 'registrar':
        require '../app/controllers/RegistroController.php';
        $controller = new RegistroController();
        $controller->registrar();
        break;

    // Ideas del cliente
    case 'idea':
        require_once '../app/controllers/IdeaController.php';
        (new IdeaController())->cliente();
        break;

    case 'agregar_idea':
        require_once '../app/controllers/IdeaController.php';
        (new IdeaController())->agregar();
        break;

    case 'buscar_idea':
        require_once '../app/controllers/IdeaController.php';
        (new IdeaController())->buscar();
        break;

    case 'eliminar_idea':
        require_once '../app/controllers/IdeaController.php';
        (new IdeaController())->eliminar();
        break;

    // Ideas del administrador
    case 'ideaAdmin':
        require_once '../app/controllers/IdeaAdminController.php';
        (new IdeaAdminController())->ver();
        break;

    case 'buscar_idea_admi':
        require_once '../app/controllers/IdeaAdminController.php';
        (new IdeaAdminController())->buscar();
        break;

    case 'eliminar_idea_admi':
        require_once '../app/controllers/IdeaAdminController.php';
        (new IdeaAdminController())->eliminar();
        break;

    case 'activar_idea_admi':
        require_once '../app/controllers/IdeaAdminController.php';
        (new IdeaAdminController())->activar();
        break;

    // Módulo de pagos y confirmación
    case 'pago':
        require '../app/controllers/PagoController.php';
        $controller = new PagoController();
        $controller->index();
        break;

    case 'confirmar_pago':
        require '../app/controllers/PagoController.php';
        $controller = new PagoController();
        $controller->confirmar();
        break;

    // Historial de compras del cliente
    case 'historial':
        require_once '../app/controllers/HistorialController.php';
        $controller = new HistorialController();
        $controller->index();
        break;

    // Inicio de sesión y cierre
    case 'sesion':
        require '../app/controllers/SesionController.php';
        $controller = new SesionController();
        $controller->index();
        break;

    case 'validar':
        require '../app/controllers/SesionController.php';
        $controller = new SesionController();
        $controller->validar();
        break;

    case 'cerrar':
        require '../app/controllers/SesionController.php';
        $controller = new SesionController();
        $controller->cerrar();
        break;

    // Recuperación de contraseña
    case 'recuperar':
        require '../app/controllers/RecuperacionController.php';
        $controller = new RecuperacionController();
        $controller->index();
        break;

    case 'guardar_codigo':
        require '../app/controllers/RecuperacionController.php';
        $controller = new RecuperacionController();
        $controller->guardar_codigo();
        break;

    case 'validar_codigo':
        require '../app/controllers/RecuperacionController.php';
        $controller = new RecuperacionController();
        $controller->validar_codigo();
        break;

    case 'guardar_nueva_contrasena':
        require '../app/controllers/RecuperacionController.php';
        $controller = new RecuperacionController();
        $controller->guardar_nueva_contrasena();
        break;

    case 'nueva_contrasena':
        require '../app/controllers/Nueva_ContraseñaController.php';
        $controller = new NuevaContrasenaController();
        $controller->index();
        break;

    // Agrega dentro del switch o lógica de enrutamiento
    case 'ConsultarCliente':
        require '../app/controllers/ConsultarClienteController.php';
        $controlador = new ConsultarClienteController();
        $controlador->index();
        break;

    case 'buscarCliente':
        require_once '../app/controllers/ConsultarClienteController.php';
        $controller = new ConsultarClienteController();
        $controller->buscar();
        break;

    case 'darDeBajaCliente':
        require_once '../app/controllers/ConsultarClienteController.php';
        $controller = new ConsultarClienteController();
        $controller->darDeBaja();
        break;

}
