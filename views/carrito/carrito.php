<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit();
}

require_once '../../config/db.php';

// Verifica si el carrito está vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$carrito = $_SESSION['carrito'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #ffc107;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h1 class="text-center mb-4">Carrito de Compras</h1>
            
            <?php if (empty($carrito)): ?>
                <p class="text-center">No hay productos en el carrito.</p>
                <div class="text-center">
                    <a href="../productos/lista.php" class="btn btn-warning">Seguir Comprando</a>
                </div>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalGeneral = 0; ?>
                        <?php foreach ($carrito as $producto): ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['nombre']) ?></td>
                            <td><?= number_format($producto['precio'], 2) ?></td>
                            <td><?= htmlspecialchars($producto['cantidad']) ?></td>
                            <td><?= number_format($producto['precio'] * $producto['cantidad'], 2) ?></td>
                            <td>
                                <form action="carrito_eliminar.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php $totalGeneral += $producto['precio'] * $producto['cantidad']; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="mt-3">
                    <h3>Total: <?= number_format($totalGeneral, 2) ?> Bs</h3>
                </div>
                <div class="mt-3">
                    <form action="../facturas/generar_factura.php" method="GET">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Cliente:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del cliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="nit" class="form-label">NIT:</label>
                            <input type="text" class="form-control" id="nit" name="nit" placeholder="Ingrese el NIT" required>
                        </div>
                        <?php foreach ($carrito as $producto): ?>
                            <input type="hidden" name="id[]" value="<?= htmlspecialchars($producto['id']) ?>">
                            <input type="hidden" name="cantidad[]" value="<?= htmlspecialchars($producto['cantidad']) ?>">
                        <?php endforeach; ?>
                        <button type="submit" class="btn btn-success">Generar Factura</button>
                    </form>
                </div>
                <div class="mt-3">
                    <form action="finalizar_compra.php" method="POST">
                        <button type="submit" class="btn btn-danger">Finalizar Compra</button>
                    </form>
                </div>
                <div class="mt-3">
                    <a href="../productos/lista.php" class="btn btn-warning">Seguir Comprando</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
