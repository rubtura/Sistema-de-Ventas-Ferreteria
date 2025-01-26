<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
    $index = $_POST['index'];

    // Verifica si el índice existe en el carrito
    if (isset($_SESSION['carrito'][$index])) {
        unset($_SESSION['carrito'][$index]);
        // Reindexa el carrito para evitar índices desordenados
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}

// Redirige nuevamente al carrito
header('Location: carrito.php');
exit();
