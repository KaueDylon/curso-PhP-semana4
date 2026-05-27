<?php

declare(strict_types=1);

namespace Todoitapi\App\Controller;

use Monolog\Logger;
use Todoitapi\App\Service\TarefaService;

class TarefaController
{
    public function __construct(
        private TarefaService $service
    ) {}

    public function criarTarefa(array $params = [], array $body = []): array
    {
        return $this->service->criarTarefa($body);
    }

    public function listarTarefas(array $params = [], array $body = []): array
    {
        return $this->service->listarTarefas();
    }

    public function listarTarefasFiltradas(array $params = [], array $body = [], array $queryParams = []): array
    {
        return $this->service->listarTarefasFiltro($queryParams);
    }


}