<?php
require_once '../../config/db.php';
require_once '../../app/controllers/ProductoController.php';

$productoController = new ProductoController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $producto = $productoController->obtenerPorId($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $productoController->editar([
        'id' => $id,
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'precio' => $precio,
        'stock' => $stock
    ]);

    header("Location: lista.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?= htmlspecialchars($producto['descripcion']) ?></textarea><br><br>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" value="<?= htmlspecialchars($producto['precio']) ?>" required><br><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($producto['stock']) ?>" required><br><br>

        <button type="submit">Guardar Cambios</button>
    </form>
    <br>
    <a href="lista.php">Volver a la lista de productos</a>
</body>
</html>
