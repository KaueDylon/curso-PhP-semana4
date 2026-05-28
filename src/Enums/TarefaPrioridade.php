<?php
declare(strict_types=1);

namespace Todoitapi\App\Enums;

enum TarefaPrioridade: string
{
    case BAIXA = 'BAIXA';
    case MEDIA = 'MEDIA';
    case ALTA = 'ALTA';
    case URGENTE = 'URGENTE';

    public function label(): string
    {
        return match($this){
            self::BAIXA => 'BAIXA',
            self::MEDIA => 'MEDIA',
            self::ALTA => 'ALTA',
            self::URGENTE => 'URGENTE',
        };
    }

}
