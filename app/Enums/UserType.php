<?php

namespace App\Enums;

use App\Enums\Traits\EnumToArray;

enum UserType: string
{
    use EnumToArray;
    case Admin = 'admin';
    case User = 'user';
}
