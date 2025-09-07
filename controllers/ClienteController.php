<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController {
    private $db;
    private $cliente;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cliente = new Cliente($this->db);
    }

    public function index() {
        return $this->cliente->listar();
    }

    public function store($nome, $email, $telefone) {
        $this->cliente->nome = $nome;
        $this->cliente->email = $email;
        $this->cliente->telefone = $telefone;
        return $this->cliente->criar();
    }

    public function edit($id) {
        return $this->cliente->buscarPorId($id);
    }

    public function update($id, $nome, $email, $telefone) {
        $this->cliente->id = $id;
        $this->cliente->nome = $nome;
        $this->cliente->email = $email;
        $this->cliente->telefone = $telefone;
        return $this->cliente->atualizar();
    }

    public function destroy($id) {
        return $this->cliente->deletar($id);
    }
}
?>