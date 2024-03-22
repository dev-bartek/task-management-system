<?php

namespace App\Enums;

use App\Enums\Traits\EnumToArray;

enum UserTypes: string
{
    use EnumToArray;
    case Admin = 'admin';
    case User = 'user';
}
