<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit();
}

require_once '../../config/db.php';
require_once '../../app/controllers/ProductoController.php';

$productoController = new ProductoController($pdo);
$productos = $productoController->listar();
if (!$productos) {
    $productos = []; // Define un array vacío si no hay productos.
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: #ffc107;
        }
        .btn-danger:hover, .btn-primary:hover, .btn-warning:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h1 class="text-center mb-4" style="font-weight: bold;">Lista de Productos</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['id']) ?></td>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                        <td><?= htmlspecialchars($producto['precio']) ?></td>
                        <td><?= htmlspecialchars($producto['stock']) ?></td>
                        <td>
                            <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                                <a href="editar.php?id=<?= htmlspecialchars($producto['id']) ?>" class="btn btn-primary btn-sm">
                                    Editar
                                </a>
                                <form action="eliminar.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                        Eliminar
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="carrito_agregar.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-shopping-cart"></i> Vender
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                <a href="agregar.php" class="btn btn-warning w-100 mt-3">Agregar Producto</a>
                <a href="../admin/dashboard.php" class="btn btn-primary w-100 mt-3">Ver Dashboard</a>
            <?php else: ?>
                <a href="../carrito/carrito.php" class="btn btn-primary w-100 mt-3">Ver Carrito</a>
            <?php endif; ?>
            <a href="../usuarios/logout.php" class="text-danger d-block mt-3 text-center">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>
