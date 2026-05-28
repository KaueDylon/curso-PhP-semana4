<?php

namespace Todoitapi\App\Model;

use Todoitapi\App\Enums\TarefaPrioridade;
use Todoitapi\App\Enums\TarefaStatus;

class TarefaModel
{
    public function __construct(
        private string $nome,
        private string $descricao,
        private TarefaPrioridade $prioridade = TarefaPrioridade::BAIXA,
        private TarefaStatus $status = TarefaStatus::PENDENTE,
        private ?int $id = null,
    )
    {

    }

    public function toArray(): array
    {
        return[
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'prioridade' => $this->prioridade->label(),
            'status' => $this->status->label(),

        ];
    }
    public function toArrayID(): array
    {
        return[
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'prioridade' => $this->prioridade->label(),
            'status' => $this->status->label(),

        ];
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getPrioridade(): TarefaPrioridade
    {
        return $this->prioridade;
    }

    public function getStatus(): TarefaStatus
    {
        return $this->status;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


}