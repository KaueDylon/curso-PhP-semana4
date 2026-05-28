<?php
declare(strict_types=1);

namespace Todoitapi\App\Enums;
enum TarefaStatus: string
{
    case PENDENTE = 'PENDENTE';
    case EMPROGRESSO = 'EM PROGRESSO';
    case CONCLUIDA = 'CONCLUIDA';

    public function label(): string
    {
        return match($this){
            self::EMPROGRESSO => 'EM PROGRESSO',
            self::PENDENTE => 'PENDENTE',
            self::CONCLUIDA => 'CONCLUIDA',
        };

    }

}