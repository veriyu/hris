<?php

namespace App\Filament\Resources\PayrollPeriods\Schemas;

use App\Enums\PayrollPeriodStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PayrollPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                DatePicker::make('payment_date')
                    ->required(),
                Select::make('status')
                    ->options(PayrollPeriodStatus::class)
                    ->required()
                    ->default(PayrollPeriodStatus::DRAFT),
            ]);
    }
}
