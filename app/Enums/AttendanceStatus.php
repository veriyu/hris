<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum AttendanceStatus: string implements HasLabel, HasColor
{
    case PRESENT = 'Present';
    case LATE = 'Late';
    case ABSENT = 'Absent';
    case HALF_DAY = 'Half-Day';
    case LEAVE = 'Leave';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PRESENT => 'Present',
            self::LATE => 'Late',
            self::ABSENT => 'Absent',
            self::HALF_DAY => 'Half-Day',
            self::LEAVE => 'Leave',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PRESENT => 'success',
            self::LATE => 'warning',
            self::ABSENT => 'danger',
            self::HALF_DAY => 'info',
            self::LEAVE => 'gray',
        };
    }
}
