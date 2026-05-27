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

    public function verTarefasFiltradas(string $filtro): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM tarefa WHERE :filtro");
    }
}