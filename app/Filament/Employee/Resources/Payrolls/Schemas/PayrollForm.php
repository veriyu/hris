<?php

namespace App\Filament\Employee\Resources\Payrolls\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PayrollForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Payroll Info')->schema([
                    Select::make('payroll_period_id')
                        ->relationship('payrollPeriod', 'name')
                        ->disabled(),
                    Select::make('employee_id')
                        ->relationship('employee', 'first_name')
                        ->disabled(),
                    Select::make('status')
                        ->options(\App\Enums\PayrollStatus::class)
                        ->disabled(),
                ])->columns(3),
                TextInput::make('basic_salary')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_allowance')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_deduction')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('net_salary')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('status')
                    ->required()
                    ->default('Draft'),
            ]);
    }
}
