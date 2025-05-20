<?php // Inicio del archivo PHP

// Incluir el modelo TarjetaCliente que maneja las operaciones sobre tarjetas asociadas al cliente
require_once __DIR__ . '/../models/TarjetaCliente.php';

/**
 * Controlador FormasPagoController
 * 
 * Este controlador permite al cliente:
 * - Visualizar las opciones de pago y sus tarjetas guardadas
 * - Guardar nuevas tarjetas
 */
class FormasPagoController {

    /**
     * Muestra la vista de formas de pago del cliente.
     * Contiene:
     * - Opciones de pago disponibles (texto)
     * - Formulario para registrar tarjetas
     * - Tarjetas guardadas visibles solo para el cliente autenticado
     */
    public function index() {
        require '../app/views/cliente/Formas_Pago.php'; // Renderiza la vista correspondiente
    }

    /**
     * Guarda una nueva tarjeta en la base de datos.
     * Este método se activa al enviar el formulario desde el cliente.
     */
    public function guardar_tarjeta() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Asegura que haya sesión iniciada
        }

        // Si no hay sesión activa, redirige al login
        if (!isset($_SESSION['idCliente'])) {
            header("Location: index.php?page=sesion");
            exit;
        }

        // Verifica que la solicitud sea POST (formulario enviado)
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            require_once __DIR__ . '/../models/TarjetaCliente.php'; // (Redundante, pero asegura inclusión)

            // Separar año y mes desde el input tipo "month"
            $exp = explode("-", $_POST['expiracion']); // Valor ejemplo: "2025-08"
            $anio = $exp[0]; // Extrae el año (2025)
            $mes = $exp[1];  // Extrae el mes (08)

            $modelo = new TarjetaCliente(); // Instanciar el modelo

            // Guardar los datos recibidos en la base de datos
            $modelo->guardar([
                'idCliente'       => $_SESSION['idCliente'],              // ID del cliente actual
                'nombreTitular'   => $_POST['nombreTitular'],             // Nombre del titular
                'numeroTarjeta'   => $_POST['numeroTarjeta'],             // Número de tarjeta
                'mesExpiracion'   => $mes,                                // Mes extraído
                'anioExpiracion'  => $anio,                               // Año extraído
                'codigoSeguridad' => $_POST['codigoSeguridad']           // Código de seguridad
            ]);

            // Alerta de confirmación y redirección
            echo "<script>
                    alert('Tarjeta guardada con éxito');
                    window.location.href='index.php?page=formasPago';
                  </script>";
        }
    }
}
