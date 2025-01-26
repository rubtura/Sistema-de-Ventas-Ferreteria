<?php
class Producto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listarProductos() {
        $stmt = $this->pdo->query("SELECT * FROM Productos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function agregarProducto($datos) {
        $stmt = $this->pdo->prepare("INSERT INTO Productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)");
        $stmt->execute([$datos['nombre'], $datos['descripcion'], $datos['precio'], $datos['stock']]);
    }
    public function eliminarProducto($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Productos WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function obtenerProductoPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Productos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function editarProducto($datos) {
        $stmt = $this->pdo->prepare("UPDATE Productos SET nombre = ?, descripcion = ?, precio = ?, stock = ? WHERE id = ?");
        $stmt->execute([$datos['nombre'], $datos['descripcion'], $datos['precio'], $datos['stock'], $datos['id']]);
    }
    public function reducirStock($id, $cantidad) {
        $stmt = $this->pdo->prepare("UPDATE Productos SET stock = stock - ? WHERE id = ? AND stock >= ?");
        return $stmt->execute([$cantidad, $id, $cantidad]);
    }
    public function incrementarStock($id, $cantidad) {
        $stmt = $this->pdo->prepare("UPDATE Productos SET stock = stock + ? WHERE id = ?");
        return $stmt->execute([$cantidad, $id]);
    }
    
}
?>
