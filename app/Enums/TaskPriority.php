<?php

namespace App\Enums;

use App\Enums\Traits\EnumToArray;

enum TaskPriority: string
{
    use EnumToArray;

    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
}
