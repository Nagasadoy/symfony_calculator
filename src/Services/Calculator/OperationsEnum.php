<?php

namespace App\Services\Calculator;

enum OperationsEnum: string
{
    case PLUS = '+';
    case MINUS = '-';

    case MULTIPLY = '*';

    case DIVIDE = '/';
}
