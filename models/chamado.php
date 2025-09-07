<?php
class Chamado
{
    private $conn;
    private $table = "chamados";

    public $id;
    public $cliente_id;
    public $usuario_id;
    public $assunto;
    public $tipo;
    public $situacao;
    public $data_inicial;
    public $hora_inicial;
    public $data_final;
    public $hora_final;
    public $descricao;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Listar chamados com filtros, paginação e ordenação
     * 
     * @param int|null $usuario_id
     * @param int|null $limit
     * @param int|null $offset
     * @param string|null $tipo
     * @return PDOStatement
     */
    public function listar($usuario_id = null, $limit = null, $offset = null, $tipo = null)
    {
        $query = "SELECT c.*, 
                     cl.nome AS cliente_nome, 
                     u.nome AS usuario_nome
              FROM " . $this->table . " c
              JOIN clientes cl ON c.cliente_id = cl.id
              JOIN usuarios u ON c.usuario_id = u.id";

        $condicoes = [];
        if ($usuario_id) {
            $condicoes[] = "c.usuario_id = :usuario_id";
        }
        if ($tipo) {
            $condicoes[] = "c.tipo = :tipo";
        }

        if (!empty($condicoes)) {
            $query .= " WHERE " . implode(" AND ", $condicoes);
        }

        $query .= " ORDER BY c.id DESC";

        // Adiciona LIMIT/OFFSET para paginação
        if ($limit !== null && $offset !== null) {
            $query .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->conn->prepare($query);

        if ($usuario_id) {
            $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
        }
        if ($tipo) {
            $stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
        }
        if ($limit !== null && $offset !== null) {
            $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt;
    }


    public function criar()
    {
        $query = "INSERT INTO " . $this->table . " 
            (cliente_id, usuario_id, assunto, tipo, situacao, data_inicial, hora_inicial, data_final, hora_final, descricao) 
            VALUES (:cliente_id, :usuario_id, :assunto, :tipo, :situacao, :data_inicial, :hora_inicial, :data_final, :hora_final, :descricao)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":cliente_id", $this->cliente_id);
        $stmt->bindParam(":usuario_id", $this->usuario_id);
        $stmt->bindParam(":assunto", $this->assunto);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":situacao", $this->situacao);
        $stmt->bindParam(":data_inicial", $this->data_inicial);
        $stmt->bindParam(":hora_inicial", $this->hora_inicial);
        $stmt->bindParam(":data_final", $this->data_final);
        $stmt->bindParam(":hora_final", $this->hora_final);
        $stmt->bindParam(":descricao", $this->descricao);

        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar()
    {
        $query = "UPDATE " . $this->table . " SET 
            cliente_id=:cliente_id, usuario_id=:usuario_id, assunto=:assunto, tipo=:tipo, situacao=:situacao, 
            data_inicial=:data_inicial, hora_inicial=:hora_inicial, 
            data_final=:data_final, hora_final=:hora_final, descricao=:descricao 
            WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":cliente_id", $this->cliente_id);
        $stmt->bindParam(":usuario_id", $this->usuario_id);
        $stmt->bindParam(":assunto", $this->assunto);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":situacao", $this->situacao);
        $stmt->bindParam(":data_inicial", $this->data_inicial);
        $stmt->bindParam(":hora_inicial", $this->hora_inicial);
        $stmt->bindParam(":data_final", $this->data_final);
        $stmt->bindParam(":hora_final", $this->hora_final);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
