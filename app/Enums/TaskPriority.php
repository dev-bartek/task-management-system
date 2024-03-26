<?php

namespace App\Enums;

use App\Enums\Traits\EnumToArray;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TaskPriority: string implements HasColor, HasLabel
{
    use EnumToArray;

    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Low => 'success',
            self::Medium => 'warning',
            self::High => 'danger',
        };
    }
}
