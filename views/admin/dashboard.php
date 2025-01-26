<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: ../usuarios/login.php');
    exit();
}

require_once '../../config/db.php';

// Total de ventas y número de ventas
$stmtVentas = $pdo->query("SELECT SUM(total) AS total_ventas, COUNT(*) AS numero_ventas FROM ventas");
$resumenVentas = $stmtVentas->fetch(PDO::FETCH_ASSOC);

// Rendimiento por empleado
$stmtEmpleados = $pdo->query("
    SELECT 
        u.nombre AS empleado,
        SUM(v.total) AS total_ventas,
        SUM(dv.cantidad) AS productos_vendidos
    FROM usuarios u
    LEFT JOIN ventas v ON u.id = v.empleado_id
    LEFT JOIN detallesventas dv ON v.id = dv.venta_id
    WHERE u.rol = 'empleado'
    GROUP BY u.id
");
$empleados = $stmtEmpleados->fetchAll(PDO::FETCH_ASSOC);

// Productos más vendidos
$stmtProductos = $pdo->query("
    SELECT 
        p.nombre,
        SUM(dv.cantidad) AS cantidad_vendida,
        p.stock
    FROM productos p
    LEFT JOIN detallesventas dv ON p.id = dv.producto_id
    GROUP BY p.id
    ORDER BY cantidad_vendida DESC
    LIMIT 5
");
$productosMasVendidos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Dashboard del Administrador</h1>
        
        <!-- Sección 1: Resumen de Ventas -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title">Resumen de Ventas</h3>
                <p><strong>Total Ventas:</strong> <?= number_format($resumenVentas['total_ventas'], 2) ?> Bs</p>
                <p><strong>Número de Ventas:</strong> <?= $resumenVentas['numero_ventas'] ?></p>
            </div>
        </div>
        
        <!-- Sección 2: Rendimiento por Empleado -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title">Rendimiento por Empleado</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Total Ventas (Bs)</th>
                            <th>Productos Vendidos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td><?= htmlspecialchars($empleado['empleado']) ?></td>
                            <td><?= number_format($empleado['total_ventas'], 2) ?></td>
                            <td><?= htmlspecialchars($empleado['productos_vendidos']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Sección 3: Productos Más Vendidos -->
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title">Productos Más Vendidos</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad Vendida</th>
                            <th>Stock Restante</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productosMasVendidos as $producto): ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['nombre']) ?></td>
                            <td><?= htmlspecialchars($producto['cantidad_vendida']) ?></td>
                            <td><?= htmlspecialchars($producto['stock']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center">
            <a href="../productos/lista.php" class="btn btn-warning">Gestionar Productos</a>
            <a href="../usuarios/logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>
