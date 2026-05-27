<?php
declare(strict_types=1);

namespace Todoitapi\App\Service;

use Todoitapi\App\Enums\TarefaPrioridade;
use Todoitapi\App\Enums\TarefaStatus;
use Todoitapi\App\Model\TarefaModel;
use Monolog\Logger;
use Todoitapi\App\Repository\TarefaRepository;

class TarefaService
{
    private TarefaRepository $repository;
    private Logger $log;

    public function __construct(Logger $log)
    {
        $this->repository = new TarefaRepository();
        $this->log = $log;
    }

    public function criarTarefa(array $body): array
    {

        $nome = $body['nome'] ?? null;
        $descricao = $body['descricao'] ?? null;
        $prioridade = $body['prioridade'] ?? null;

        if (empty($nome)) {
            $this->log->warning("Não foi inserido o nome da tarefa na req");
            $erros[] = 'Campo nome é obrigatório.';

        }
        if (empty($descricao)) {
            $this->log->warning("Não foi inserido a desc. da tarefa na req.");
            $erros[] = 'Campo desc. é obrigatório.';

        }

        if (!empty($prioridade)) {
            $prioridadeEnum = TarefaPrioridade::tryFrom(
                mb_strtolower($prioridade)
            );
            if ($prioridadeEnum === null) {
                $this->log->warning("Não foi inserida um tipo de prioridade correto na req.");
                $erros[] = 'Campo prioridade com tipo inválido.';
            } else {
                $prioridade = TarefaPrioridade::tryFrom(
                    mb_strtolower($prioridade));
            }
        } else {
            $prioridade = TarefaPrioridade::BAIXA;
        }

        if (!empty($erros)) {
            http_response_code(400);
            return [
                'sucesso' => false,
                'info' => $erros
            ];
        }

        $tarefa = new TarefaModel($nome, $descricao, $prioridade);
        $this->repository->criarTarefas($tarefa);


        return [
            'sucesso' => true,
            'info' => 'Tarefa criada com sucesso.'
        ];

    }

    public function listarTarefasFiltro(array $queryParams): array
    {
        $nome = $body['nome'] ?? null;
        $descricao = $body['descricao'] ?? null;
    }

    public function listarTarefas(): array
    {
        $tarefas = $this->repository->verTarefas();

        if(empty($tarefas)){

            return [
                'sucesso' => true,
                'info' => 'Nenhuma tarefa disponível para ser listada.',
            ];
        }

        return [
            'sucesso' => true,
            'info' => $tarefas,
        ];

    }

}