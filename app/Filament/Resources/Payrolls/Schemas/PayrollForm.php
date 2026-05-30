<?php

namespace App\Filament\Resources\Payrolls\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PayrollForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Section::make('Payroll Info')->schema([
                    Select::make('payroll_period_id')
                        ->relationship('payrollPeriod', 'name')
                        ->required(),
                    Select::make('employee_id')
                        ->relationship('employee', 'first_name')
                        ->required(),
                    TextInput::make('status')
                        ->required()
                        ->default('Draft'),
                ])->columns(3),
                \Filament\Forms\Components\Section::make('Salary Details')->schema([
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
                ])->columns(4),
                \Filament\Forms\Components\Repeater::make('items')
                    ->relationship('items')
                    ->schema([
                        TextInput::make('name')->required(),
                        Select::make('type')
                            ->options([
                                'Earning' => 'Earning',
                                'Deduction' => 'Deduction',
                            ])->required(),
                        TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
