<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ferrepil;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "¡Conexión a la base de datos establecida correctamente!";
} catch (PDOException $e) {
    echo "Error al conectar con la base de datos: " . $e->getMessage();
}
?>
