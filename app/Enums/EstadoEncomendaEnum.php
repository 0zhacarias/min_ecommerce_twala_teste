<?php

namespace App\Enums;

enum EstadoEncomendaEnum: string
{
    case PENDENTE = 'Pendente';
    case PROCESSANDO = 'Processando';
    case ENVIADA = 'Enviada';
    case ENTREGUE = 'Entregue';
    case CANCELADA = 'Cancelada';

}
