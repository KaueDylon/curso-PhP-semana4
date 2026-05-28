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
            http_response_code(200),
            'sucesso' => true,
            'info' => 'Tarefa criada com sucesso.'
        ];

    }

    public function listarTarefasFiltro(array $queryParams): array
    {
        $status = mb_strtoupper($queryParams['status'] ?? null);
        $prioridade = mb_strtoupper($queryParams['prioridade'] ?? null);


        if (empty($prioridade)) {
            $this->log->warning("Não foi inserido nenhum filtro de prioridade na queryParams.");
        }

        if (empty($status)) {
            $this->log->warning("Não foi inserido nenhum filtro de status na queryParams.");
        }

        return $this->repository->verTarefasFiltradas($status, $prioridade);

    }

    public function listarTarefasID(array $params)
    {

        $id = filter_var($params['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            $this->log->warning("ID da tarefa não é um número inteiro.");
            $erros[] = 'ID da tarefa inserido não é um número.';
        }

        if (!empty($erros)) {
            http_response_code(400);
            return [
                'sucesso' => false,
                'info' => $erros
            ];
        }

        $tarefa = $this->repository->verTatefaPorID($id);

        if(empty($tarefa)){
            http_response_code(200);
            return [
                'sucesso' => true,
                'info' => 'Nenhuma tarefa com este ID foi encontrado.'
            ];
        }

        return [
            http_response_code(200),
            'sucesso' => true,
            'info' => $tarefa
        ];

    }

    public function listarTarefas(): array
    {
        $tarefas = $this->repository->verTarefas();

        if(empty($tarefas)){

            return [
                http_response_code(200),
                'sucesso' => true,
                'info' => 'Nenhuma tarefa disponível para ser listada.',
            ];
        }

        return [
            http_response_code(200),
            'sucesso' => true,
            'info' => $tarefas,
        ];

    }

    public function deletarTarefa(array $params): array
    {

        $id = filter_var($params['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            $this->log->warning("ID da tarefa não é um número inteiro.");
            $erros[] = 'ID da tarefa inserido não é um número.';
        }

        $tarefa = $this->repository->verTatefaPorID($id);

        if(empty($tarefa)){
            http_response_code(200);
            return [
                'sucesso' => true,
                'info' => 'Nenhuma tarefa com este ID foi encontrado.'
            ];
        }

        $this->repository->deletarTarefa($id);

        http_response_code(200);
        return [
            'sucesso' => true,
            'info' => 'Tarefa deletada com sucesso.'
        ];

    }

    public function editarTarefa(array $params, array $body): array
    {
        $id = filter_var($params['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            $this->log->warning("ID da tarefa não é um número inteiro.");
            $erros[] = 'ID da tarefa inserido não é um número.';
        }

        $edt = $this->repository->verTatefaPorID($id);

        if(empty($edt)){
            $this->log->warning("Usuário não encontrado para edição.");
            $erros[] = 'ID informado não trouxe nenhum usuário.';
        }


        if (!empty($erros)) {
            http_response_code(400);
            return [
                'sucesso' => false,
                'info' => $erros
            ];
        }

        $edtNome = $body['nome'] ?? $edt['nome'];
        $edtDescricao = $body['descricao'] ?? $edt['descricao'];
        $edtPrioridade = $body['prioridade'] ?? $edt['prioridade'];
        $edtStatus = $body['status'] ?? $edt['status'];

        $tarefaEditar = new TarefaModel($edtNome,
                                        $edtDescricao,
                                        TarefaPrioridade::from(mb_strtoupper($edtPrioridade)),
                                        TarefaStatus::from(mb_strtoupper($edtStatus)),
                                        $id);


        $this->repository->editarTarefa($tarefaEditar);

        return [
            'sucesso' => true,
            'info' => 'Usuário editado com sucesso.'
        ];

    }

}