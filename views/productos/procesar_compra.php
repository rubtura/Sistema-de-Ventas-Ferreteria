<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit();
}
require_once '../../config/db.php';
require_once '../../app/controllers/ProductoController.php';

$productoController = new ProductoController($pdo);

$id = $_POST['id'];
$cantidad = $_POST['cantidad'];

if ($productoController->reducirStock($id, $cantidad)) {
    echo "<script>alert('Compra realizada con éxito.'); window.location.href = 'lista.php';</script>";
} else {
    echo "<script>alert('Error al procesar la compra.'); window.location.href = 'lista.php';</script>";
}
?>
