<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum PayrollStatus: string implements HasLabel, HasColor
{
    case DRAFT = 'Draft';
    case PAID = 'Paid';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PAID => 'Paid',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::PAID => 'success',
        };
    }
}
