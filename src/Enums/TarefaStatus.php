<?php
declare(strict_types=1);

namespace Todoitapi\App\Enums;
enum TarefaStatus: string
{
    case PENDENTE = 'pendente';
    case EMPROGRESSO = 'em progresso';
    case CONCLUIDA = 'concluida';

    public function label(): string
    {
        return match($this){
            self::EMPROGRESSO => 'EM PROGRESSO',
            self::PENDENTE => 'PENDENTE',
            self::CONCLUIDA => 'CONCLUIDA',
        };

    }

}