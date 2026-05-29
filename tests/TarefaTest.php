<?php

namespace tests;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Todoitapi\App\Repository\TarefaRepository;
use Todoitapi\App\Service\TarefaService;

class TarefaTest extends TestCase{

    public function  test_criar_tarefa_sem_nome()
    {

        $logger = $this->createMock(Logger::class);
        $repository = $this->createMock(TarefaRepository::class);

        $service = new TarefaService($logger, $repository);

        $resultado = $service->criarTarefa([
            'descricao' => 'Teste'
        ]);

        $this->assertFalse($resultado['sucesso']);

        $this->assertContains(
            'Campo nome é obrigatório.',
            $resultado['info']
        );

    }

    public function test_criar_tarefa_com_nome()
    {
        $logger = $this->createMock(Logger::class);
        $repository = $this->createMock(TarefaRepository::class);

        $service = new TarefaService($logger, $repository);

        $resultado = $service->criarTarefa([
            'nome' => 'Desligar o notebook',
            'descricao' => 'Evitar que ele esquente muito',
            'prioridade' => 'baixa'
        ]);

        $this->assertTrue($resultado['sucesso']);

        $this->assertEquals(
            'Tarefa criada com sucesso.',
            $resultado['info']
        );

    }


}