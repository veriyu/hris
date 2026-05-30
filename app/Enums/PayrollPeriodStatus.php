<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum PayrollPeriodStatus: string implements HasLabel, HasColor
{
    case DRAFT = 'Draft';
    case PROCESSING = 'Processing';
    case COMPLETED = 'Completed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::PROCESSING => 'warning',
            self::COMPLETED => 'success',
        };
    }
}
