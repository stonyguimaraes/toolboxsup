<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../models/Usuario.php";



class UsuarioController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }


    public function index()
    {
        return $this->usuario->listar();
    }

    public function login($email, $senha)
    {
        return $this->usuario->login($email, $senha);
    }


    public function store($dados)
    {
        $this->usuario->nome = $dados['nome'];
        $this->usuario->email = $dados['email'];
        $this->usuario->senha = $dados['senha'];
        return $this->usuario->criar();
    }

    public function show($id)
    {
        return $this->usuario->buscar($id);
    }

    public function update($dados)
    {
        $this->usuario->id = $dados['id'];
        $this->usuario->nome = $dados['nome'];
        $this->usuario->email = $dados['email'];
        return $this->usuario->atualizar();
    }

    public function destroy($id)
    {
        $this->usuario->id = $id;
        return $this->usuario->deletar();
    }
}
