<?php

declare(strict_types=1);

namespace Todoitapi\App\Controller;

use Todoitapi\App\Http\Router;
use Todoitapi\App\Controller\TarefaController;

/** @var Router $router */

$router->post('/tarefas', [TarefaController::class, 'criarTarefa']);
$router->get('/tarefas', [TarefaController::class, 'listarTarefas']);
$router->get('/tarefas/filtro', [TarefaController::class, 'listarTarefasFiltradas']);
