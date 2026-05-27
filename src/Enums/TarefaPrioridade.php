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
            self::BAIXA => 'Baixa',
            self::MEDIA => 'Media',
            self::ALTA => 'Alta',
            self::URGENTE => 'Urgente',
        };
    }

}
