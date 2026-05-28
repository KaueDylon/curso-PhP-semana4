<?php
declare(strict_types=1);

namespace Todoitapi\App\Enums;

enum TarefaPrioridade: string
{
    case BAIXA = 'baixa';
    case MEDIA = 'media';
    case ALTA = 'alta';
    case URGENTE = 'urgente';

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
