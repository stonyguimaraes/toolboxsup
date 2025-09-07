<?php
class Requisicao
{
    private $db;
    public $id;
    public $cliente_id;
    public $status;
    public $data;
    public $previsao_entrega;
    public $colaborador;
    public $sugestao;



    public function __construct($db)
    {
        $this->db = $db;
    }

    public function listar()
    {
        $query = "SELECT r.*, c.nome AS cliente_nome
                  FROM requisicoes r
                  JOIN clientes c ON r.cliente_id = c.id
                  ORDER BY r.id DESC";
        return $this->db->query($query);
    }

    public function criar()
    {
        $query = "INSERT INTO requisicoes (cliente_id, status, data, previsao_entrega, colaborador, sugestao)
                  VALUES (:cliente_id, :status, :data, :previsao_entrega, :colaborador, :sugestao)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cliente_id', $this->cliente_id);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':data', $this->data);
        $stmt->bindParam(':previsao_entrega', $this->previsao_entrega);
        $stmt->bindParam(':colaborador', $this->colaborador);
        $stmt->bindParam(':sugestao', $this->sugestao);
        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM requisicoes WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar()
    {
        $query = "UPDATE requisicoes SET 
                    cliente_id = :cliente_id,
                    status = :status,
                    data = :data,
                    previsao_entrega = :previsao_entrega,
                    colaborador = :colaborador,
                    sugestao = :sugestao
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cliente_id', $this->cliente_id);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':data', $this->data);
        $stmt->bindParam(':previsao_entrega', $this->previsao_entrega);
        $stmt->bindParam(':colaborador', $this->colaborador);
        $stmt->bindParam(':sugestao', $this->sugestao);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function deletar($id)
    {
        $query = "DELETE FROM requisicoes WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
