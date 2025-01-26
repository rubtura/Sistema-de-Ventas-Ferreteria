<?php
class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function autenticar($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM Usuarios WHERE username = ?");
        $stmt->execute([$username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && md5($password) === $usuario['password']) {
            return $usuario;
        }

        return false;
    }
}
?>
