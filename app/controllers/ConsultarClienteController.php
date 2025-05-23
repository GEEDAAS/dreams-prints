<?php
require_once '../app/models/Cliente.php';

class ConsultarClienteController {
    
    // Muestra todos los clientes activos
    public function index() {
        $clientes = Cliente::obtenerTodos();
        require '../app/views/admin/Consultar_Cliente.php';
    }

    // Busca clientes por nombre o correo
    public function buscar() {
        $termino = $_POST['termino'];
        $clientes = Cliente::buscarPorNombreOCorreo($termino);
        require '../app/views/admin/Consultar_Cliente.php';
    }

    // Cambia el estado de un cliente a 'Inactivo'
    public function darDeBaja() {
        $id = $_GET['id'];
        Cliente::cambiarEstado($id, 'Inactivo');
        header('Location: index.php?page=ConsultarCliente');
    }
}
