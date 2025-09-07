<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function login($email, $senha)
    {
        return $this->usuario->login($email, $senha);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: ../views/login.php");
        exit;
    }
}
