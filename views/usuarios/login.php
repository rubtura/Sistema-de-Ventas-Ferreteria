<?php
session_start();
require_once '../../config/db.php';
require_once __DIR__ . '/../../app/controllers/UsuarioController.php';

$usuarioController = new UsuarioController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $usuario = $usuarioController->autenticar($username, $password);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario; // Guardar datos del usuario en sesión

        // Redireccionar según el rol
        if ($usuario['rol'] === 'admin') {
            header('Location: ../admin/dashboard.php'); // Redirige al dashboard de admin
        } else {
            header('Location: ../productos/lista.php'); // Redirige a la lista de productos para empleados
        }
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - FERREPIL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            background: linear-gradient(135deg, #ffc107, #f39c12);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Fondo animado */
        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: move 10s infinite ease-in-out;
        }

        @keyframes move {
            0% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(50px, 50px);
            }
            100% {
                transform: translate(-50px, -50px);
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 2rem;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, #ffc107, #f39c12);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .form-control {
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border: 1px solid #f39c12;
            box-shadow: 0 0 10px rgba(243, 156, 18, 0.5);
        }

        h3 {
            font-weight: 600;
            color: #2c3e50;
        }

        .error-message {
            color: #e74c3c;
            margin-top: 1rem;
            display: none;
        }

        .icon {
            font-size: 4rem;
            color: #f39c12;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="animated-bg">
        <div class="circle" style="width: 150px; height: 150px; top: 10%; left: 20%;"></div>
        <div class="circle" style="width: 200px; height: 200px; top: 50%; left: 70%;"></div>
        <div class="circle" style="width: 100px; height: 100px; top: 80%; left: 40%;"></div>
    </div>
    <div class="card">
        <i class="fas fa-tools icon"></i>
        <h3>FERREPIL</h3>
        <p class="text-muted">Tu solución en herramientas</p>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <input type="text" name="username" id="username" class="form-control" required placeholder="Ingresa tu usuario">
            </div>
            <div class="mb-3">
                <input type="password" name="password" id="password" class="form-control" required placeholder="Ingresa tu contraseña">
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
        <div class="error-message" id="error-message">
            Usuario o contraseña incorrectos.
        </div>
        <div class="text-center mt-3">
            <p class="text-muted">¿No tienes una cuenta? <a href="registro.php" class="text-decoration-none">Regístrate</a></p>
        </div>
    </div>
</body>
</html>






