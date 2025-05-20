<?php
// Se incluye el archivo de configuración de la base de datos para establecer la conexión
require_once __DIR__ . '/../../config/database.php';

// Se define la clase Producto, que contiene métodos para gestionar los productos en el sistema
class Producto {
    // Propiedad privada para almacenar la conexión a la base de datos (objeto PDO)
    private $conn;

    // Constructor: se inicializa la conexión a la base de datos al crear una instancia de la clase
    public function __construct() {
        $db = new Database();            // Se crea una instancia de la clase Database
        $this->conn = $db->conectar();   // Se almacena la conexión PDO en la propiedad $conn
    }

    // Método para obtener todos los productos que están disponibles (estado 'Disponible')
    public function obtenerTodos() {
        // Consulta SQL para seleccionar todos los productos con estado 'Disponible'
        $sql = "SELECT * FROM Producto WHERE estadoProducto = 'Disponible'";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta SQL
        $stmt->execute();                   // Se ejecuta la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se retornan todos los registros como un arreglo asociativo
    }

    // Método para agregar un nuevo producto a la base de datos
    public function agregarProducto($nombre, $descripcion, $precio, $categoria, $stock, $estado, $imagen) {
        // Consulta SQL para insertar un nuevo producto con los datos proporcionados
        $sql = "INSERT INTO Producto (nombreProducto, descripcionProducto, precioProducto, categoriaProducto, estadoProducto, imagenProducto, cantidadProductoStock)
                VALUES (:nombre, :descripcion, :precio, :categoria, :estado, :imagen, :stock)";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        // Se vinculan los parámetros con sus respectivos valores
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':estado', $estado);
        // Se especifica que el parámetro 'imagen' puede ser un LOB (Binary Large Object) en caso de ser binario
        $stmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB);
        $stmt->bindParam(':stock', $stock);
        
        return $stmt->execute(); // Se ejecuta la consulta y se retorna el resultado (true o false)
    }

    // Método para cambiar el estado de un producto (por ejemplo: de 'Disponible' a 'No Disponible')
    public function cambiarEstado($id, $estado) {
        // Consulta SQL para actualizar el campo estadoProducto del producto especificado
        $sql = "UPDATE Producto SET estadoProducto = :estado WHERE idProducto = :id";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':estado', $estado); // Se vincula el nuevo estado
        $stmt->bindParam(':id', $id);          // Se vincula el ID del producto
        return $stmt->execute();              // Se ejecuta y se retorna el resultado
    }

    // Método para filtrar productos según su nombre y/o categoría, manteniendo aquellos con estado 'Disponible'
    public function filtrar($nombre = '', $categoria = '') {
        // Se construye la consulta base para obtener productos disponibles
        $sql = "SELECT * FROM Producto WHERE estadoProducto = 'Disponible'";
        
        // Si se proporciona un valor para el nombre, se añade un filtro utilizando LIKE para coincidencias parciales
        if (!empty($nombre)) {
            $sql .= " AND nombreProducto LIKE :nombre";
        }
        
        // Si se proporciona una categoría, se añade un filtro similar para la categoría
        if (!empty($categoria)) {
            $sql .= " AND categoriaProducto LIKE :categoria";
        }
        
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta dinámica
        
        // Se vincula el parámetro para el nombre si se proporcionó
        if (!empty($nombre)) {
            $nombre = "%$nombre%"; // Se añaden comodines para la búsqueda parcial
            $stmt->bindParam(':nombre', $nombre);
        }
        
        // Se vincula el parámetro para la categoría si se proporcionó
        if (!empty($categoria)) {
            $categoria = "%$categoria%"; // Se añaden comodines para la búsqueda parcial
            $stmt->bindParam(':categoria', $categoria);
        }
        
        $stmt->execute(); // Se ejecuta la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se retornan los productos filtrados
    }

    // Método para obtener un producto específico por su nombre
    public function obtenerPorNombre($nombre) {
        // Consulta SQL para buscar un producto cuyo nombre coincida exactamente
        $sql = "SELECT * FROM Producto WHERE nombreProducto = :nombre";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':nombre', $nombre); // Se vincula el nombre del producto
        $stmt->execute();                     // Se ejecuta la consulta
        return $stmt->fetch(PDO::FETCH_ASSOC); // Se retorna el producto encontrado, o false si no existe
    }
    
    // Método para restar una cantidad específica del stock de un producto
    // Se asegura que el stock actual sea mayor o igual a la cantidad a restar antes de proceder
    public function restarStock($idProducto, $cantidad) {
        // Consulta SQL que decrementa el stock, utilizando una condición para evitar valores negativos
        $sql = "UPDATE Producto SET cantidadProductoStock = cantidadProductoStock - :cantidad 
                WHERE idProducto = :idProducto AND cantidadProductoStock >= :cantidad";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':cantidad', $cantidad);   // Se vincula la cantidad a restar
        $stmt->bindParam(':idProducto', $idProducto); // Se vincula el ID del producto
        return $stmt->execute(); // Se ejecuta la consulta y se retorna el resultado
    }

    // Método para obtener la información de un producto por su ID
    public function obtenerPorId($id) {
        // Consulta SQL para seleccionar el producto según su ID
        $sql = "SELECT * FROM Producto WHERE idProducto = :id";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        $stmt->bindParam(':id', $id);        // Se vincula el ID del producto
        $stmt->execute();                    // Se ejecuta la consulta
        return $stmt->fetch(PDO::FETCH_ASSOC); // Se retorna el producto encontrado
    }
    
    // Método para actualizar la información de un producto
    // Recibe el ID del producto y un arreglo asociativo con los nuevos datos
    public function actualizar($id, $data) {
        // Consulta SQL para actualizar varios campos de la tabla Producto
        $sql = "UPDATE Producto SET 
                    nombreProducto = :nombre,
                    descripcionProducto = :descripcion,
                    precioProducto = :precio,
                    categoriaProducto = :categoria,
                    cantidadProductoStock = :stock
                WHERE idProducto = :id";
        $stmt = $this->conn->prepare($sql); // Se prepara la consulta
        
        // Se vinculan los parámetros con sus valores correspondientes del arreglo $data
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':categoria', $data['categoria']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':id', $id); // Se vincula el ID del producto a actualizar
        
        return $stmt->execute(); // Se ejecuta la actualización y se retorna el resultado
    }
    
}
