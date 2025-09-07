<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Requisicao.php';

class RequisicaoController
{
    private $db;
    private $requisicao;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->requisicao = new Requisicao($this->db);
    }

    public function index()
    {
        return $this->requisicao->listar();
    }

    public function store($dados)
    {
        $this->requisicao->cliente_id = $dados['cliente_id'];
        $this->requisicao->status = $dados['status'];
        $this->requisicao->data = $dados['data'];
        $this->requisicao->previsao_entrega = $dados['previsao_entrega'];
        $this->requisicao->colaborador = $dados['colaborador'];
        $this->requisicao->sugestao = $dados['sugestao'];
        return $this->requisicao->criar();
    }

    public function edit($id)
    {
        return $this->requisicao->buscarPorId($id);
    }

    public function update($id, $dados)
    {
        $this->requisicao->id = $id;
        $this->requisicao->cliente_id = $dados['cliente_id'];
        $this->requisicao->status = $dados['status'];
        $this->requisicao->data = $dados['data'];
        $this->requisicao->previsao_entrega = $dados['previsao_entrega'];
        $this->requisicao->colaborador = $dados['colaborador'];
        $this->requisicao->sugestao = $dados['sugestao'];
        return $this->requisicao->atualizar();
    }

    public function destroy($id)
    {
        return $this->requisicao->deletar($id);
    }
}
