<?php
require_once '../../config/db.php';
require_once '../../app/controllers/ProductoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productoController = new ProductoController($pdo);

    $id = $_POST['id'];
    $productoController->eliminar($id);

    header("Location: lista.php"); // Redirige a la lista después de eliminar
    exit();
}
?>
