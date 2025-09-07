<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Chamado.php';

class ChamadoController
{
    private $db;
    private $chamado;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->chamado = new Chamado($this->db);
    }

    // Lista todos ou só de um usuário
    public function index($usuario_id = null, $limit = null, $offset = null, $tipo = null)
    {
        return $this->chamado->listar($usuario_id, $limit, $offset, $tipo);
    }


    // Criar chamado
    public function store($dados)
    {
        $this->chamado->cliente_id   = $dados['cliente_id'];
        $this->chamado->usuario_id   = $dados['usuario_id'];
        $this->chamado->assunto      = $dados['assunto'];
        $this->chamado->tipo         = $dados['tipo'];
        $this->chamado->situacao     = $dados['situacao'];
        $this->chamado->data_inicial = $dados['data_inicial'];
        $this->chamado->hora_inicial = $dados['hora_inicial'];
        $this->chamado->data_final   = $dados['data_final'];
        $this->chamado->hora_final   = $dados['hora_final'];
        $this->chamado->descricao    = $dados['descricao'];

        if ($this->chamado->criar()) {
            $_SESSION['mensagem'] = [
                'tipo' => 'success',
                'texto' => 'Chamado salvo com sucesso!'
            ];
            return true;
        } else {
            $_SESSION['mensagem'] = [
                'tipo' => 'danger',
                'texto' => 'Erro ao salvar o chamado.'
            ];
            return false;
        }
    }

    // Buscar chamado por ID
    public function edit($id)
    {
        return $this->chamado->buscarPorId($id);
    }

    // Atualizar chamado
    public function update($id, $dados)
    {
        $this->chamado->id           = $id;
        $this->chamado->cliente_id   = $dados['cliente_id'];
        $this->chamado->usuario_id   = $dados['usuario_id'];
        $this->chamado->assunto      = $dados['assunto'];
        $this->chamado->tipo         = $dados['tipo'];
        $this->chamado->situacao     = $dados['situacao'];
        $this->chamado->data_inicial = $dados['data_inicial'];
        $this->chamado->hora_inicial = $dados['hora_inicial'];
        $this->chamado->data_final   = $dados['data_final'];
        $this->chamado->hora_final   = $dados['hora_final'];
        $this->chamado->descricao    = $dados['descricao'];

        if ($this->chamado->atualizar()) {
            $_SESSION['mensagem'] = [
                'tipo' => 'success',
                'texto' => 'Chamado atualizado com sucesso!'
            ];
            return true;
        } else {
            $_SESSION['mensagem'] = [
                'tipo' => 'danger',
                'texto' => 'Erro ao atualizar o chamado.'
            ];
            return false;
        }
    }

    // Deletar chamado
    public function destroy($id)
    {
        if ($this->chamado->deletar($id)) {
            $_SESSION['mensagem'] = [
                'tipo' => 'success',
                'texto' => 'Chamado excluído com sucesso!'
            ];
            return true;
        } else {
            $_SESSION['mensagem'] = [
                'tipo' => 'danger',
                'texto' => 'Erro ao excluir o chamado.'
            ];
            return false;
        }
    }
}
