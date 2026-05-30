<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SalaryComponentType: string implements HasLabel, HasColor
{
    case ALLOWANCE = 'Allowance';
    case DEDUCTION = 'Deduction';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ALLOWANCE => 'Allowance (Penambah)',
            self::DEDUCTION => 'Deduction (Pengurang)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ALLOWANCE => 'success',
            self::DEDUCTION => 'danger',
        };
    }
}
