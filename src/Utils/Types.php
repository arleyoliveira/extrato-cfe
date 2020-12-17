<?php

namespace ArleyOliveira\Utils;

abstract class Types
{
    const PAGAMENTOS = array(
        1 => "Dinheiro",
        2 => 'Cheque',
        3 => 'Cartão de Crédito',
        4 => 'Cartão de Débito',
        5 => 'Crédito Loja',
        10 => 'Vale Alimentação',
        11 => 'Vale Refeição',
        12 => 'Vale Presente',
        13 => 'Vale Combustível',
        99 => 'Outros'
    );
}