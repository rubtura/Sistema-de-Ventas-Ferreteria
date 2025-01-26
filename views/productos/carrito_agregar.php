<?php
session_start();
require_once '../../config/db.php';
require_once '../../app/controllers/ProductoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $cantidad = 1; // Suponiendo que siempre se agrega 1 unidad al carrito

    $productoController = new ProductoController($pdo);

    // Obtener detalles del producto
    $producto = $productoController->obtenerPorId($id);

    if ($producto && $producto['stock'] >= $cantidad) {
        // Reducir el stock en la base de datos
        $productoController->reducirStock($id, $cantidad);

        // Agregar el producto al carrito en sesión
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
        } else {
            $_SESSION['carrito'][$id] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $cantidad,
            ];
        }

        echo "<script>alert('Producto agregado al carrito.'); window.location.href = 'lista.php';</script>";
    } else {
        echo "<script>alert('Stock insuficiente.'); window.location.href = 'lista.php';</script>";
    }
}
?>
