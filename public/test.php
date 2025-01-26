<?php
require_once '../config/db.php';

try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Conexión exitosa. Tablas disponibles:<br>";
    foreach ($tables as $table) {
        echo "- " . $table['Tables_in_ferrepil'] . "<br>";
    }
} catch (PDOException $e) {
    echo "Error al conectar: " . $e->getMessage();
}
?>
