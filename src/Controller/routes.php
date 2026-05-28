<?php

declare(strict_types=1);

namespace Todoitapi\App\Controller;

use Todoitapi\App\Http\Router;
use Todoitapi\App\Controller\TarefaController;

/** @var Router $router */

$router->post('/tarefas', [TarefaController::class, 'criarTarefa']);
$router->get('/tarefas', [TarefaController::class, 'listarTarefas']);
$router->get('/tarefas/{id}', [TarefaController::class, 'listarTarefasID']);
$router->get('/tarefas/filtro', [TarefaController::class, 'listarTarefasFiltradas']);
$router->delete('/tarefas/delete/{id}', [TarefaController::class, 'deletarTarefa']);
$router->put('/tarefas/editar/{id}', [TarefaController::class, 'editarTarefa']);
