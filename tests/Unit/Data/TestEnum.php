<?php

namespace Tests\Unit\Data;

use App\Enums\Traits\EnumToArray;

enum TestEnum: string {

    use EnumToArray;
    case FirstName = 'first value';
    case SecondName = 'second value';
}
