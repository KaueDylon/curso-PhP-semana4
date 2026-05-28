<?php
declare(strict_types=1);

namespace Todoitapi\App\Repository;

use PDO;
use Todoitapi\App\Config\Database;
use Todoitapi\App\Model\TarefaModel;

class TarefaRepository
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = Database::getConnection();
    }

    public function criarTarefas(TarefaModel $tarefaModel): void
    {

        $stmt = $this->PDO->prepare(
            "INSERT INTO tarefa (nome, descricao, prioridade, status)
                    VALUES (:nome, :descricao, :prioridade, :status)");

        $stmt->execute($tarefaModel->toArray());
    }

    public function verTarefas(): array
    {
        $stmt = $this->PDO->query("SELECT * FROM tarefa");
        $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        return $tarefas;
    }

    public function verTatefaPorID($id): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM tarefa WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $tarefa = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        return $tarefa;
    }

    public function verTarefasFiltradas(?string $status, ?string $prioridade): array
    {
        $qry = "SELECT * FROM tarefa WHERE 1=1";
        $params = [];

        if (!empty($status)) {
            $qry .= " AND status = :status";
            $params['status'] = $status;
        }

        if (!empty($prioridade)) {
            $qry .= " AND prioridade = :prioridade";
            $params['prioridade'] = $prioridade;
        }

        $stmt = $this->PDO->prepare($qry);
        $stmt->execute($params);

        $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        return $tarefas;
    }

    public function deletarTarefa(int $id): void
    {
        $stmt = $this->PDO->prepare(
            "DELETE from tarefa WHERE id = :id");
        $stmt->execute([':id' => $id]);

    }
}