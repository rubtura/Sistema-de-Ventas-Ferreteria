<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct($pdo) {
        $this->usuarioModel = new Usuario($pdo);
    }

    public function autenticar($username, $password) {
        return $this->usuarioModel->autenticar($username, $password);
    }
}
?>
