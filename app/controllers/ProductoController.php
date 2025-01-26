<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    private $productoModel;
    private $pdo; // Declaramos la propiedad $pdo

    public function __construct($pdo) {
        $this->pdo = $pdo; // Asignamos $pdo a la propiedad de la clase
        $this->productoModel = new Producto($pdo);
    }

    public function listar() {
        return $this->productoModel->listarProductos();
    }

    public function agregar($datos) {
        $this->productoModel->agregarProducto($datos);
    }

    public function eliminar($id) {
        $this->productoModel->eliminarProducto($id);
    }

    public function obtenerPorId($id) {
        return $this->productoModel->obtenerProductoPorId($id);
    }

    public function editar($datos) {
        $this->productoModel->editarProducto($datos);
    }

    public function reducirStock($id, $cantidad) {
        // Validamos que el stock sea suficiente antes de realizar la operación
        $sql = "UPDATE productos SET stock = stock - ? WHERE id = ? AND stock >= ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$cantidad, $id, $cantidad]);
    }
    public function obtenerProductoPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Productos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
?>
