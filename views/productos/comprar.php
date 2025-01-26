<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit();
}
require_once '../../config/db.php';
require_once '../../app/controllers/ProductoController.php';

$productoController = new ProductoController($pdo);
$producto = $productoController->obtenerPorId($_POST['id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #ffc107;">
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h1 class="text-center mb-4">Comprar Producto</h1>
            <form action="procesar_compra.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Producto</label>
                    <input type="text" id="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" max="<?= htmlspecialchars($producto['stock']) ?>" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Generar Compra</button>
            </form>
        </div>
    </div>
</body>
</html>
