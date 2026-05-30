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
                \Filament\Schemas\Components\Section::make('Payroll Info')->schema([
                    Select::make('payroll_period_id')
                        ->relationship('payrollPeriod', 'name')
                        ->required(),
                    Select::make('employee_id')
                        ->relationship('employee', 'first_name')
                        ->required(),
                    Select::make('status')
                        ->options(\App\Enums\PayrollStatus::class)
                        ->required()
                        ->default(\App\Enums\PayrollStatus::DRAFT),
                ])->columns(3),
                \Filament\Schemas\Components\Section::make('Salary Details')->schema([
                    TextInput::make('basic_salary')
                        ->required()
                        ->numeric()
                        ->default(0.0)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (\Filament\Forms\Get $get, \Filament\Forms\Set $set) => self::updateTotals($get, $set, false)),
                    TextInput::make('total_allowance')
                        ->required()
                        ->numeric()
                        ->readOnly()
                        ->default(0.0),
                    TextInput::make('total_deduction')
                        ->required()
                        ->numeric()
                        ->readOnly()
                        ->default(0.0),
                    TextInput::make('net_salary')
                        ->required()
                        ->numeric()
                        ->readOnly()
                        ->default(0.0),
                ])->columns(4),
                \Filament\Forms\Components\Repeater::make('items')
                    ->relationship('items')
                    ->schema([
                        Select::make('salary_component_id')
                            ->relationship('component', 'name')
                            ->live()
                            ->afterStateUpdated(function ($state, \Filament\Forms\Set $set) {
                                if ($state) {
                                    $component = \App\Models\SalaryComponent::find($state);
                                    if ($component) {
                                        $set('name', $component->name);
                                        $set('type', $component->type->value);
                                    }
                                }
                            }),
                        TextInput::make('name')->required(),
                        Select::make('type')
                            ->options(\App\Enums\SalaryComponentType::class)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (\Filament\Forms\Get $get, \Filament\Forms\Set $set) => self::updateTotals($get, $set, true)),
                        TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (\Filament\Forms\Get $get, \Filament\Forms\Set $set) => self::updateTotals($get, $set, true)),
                    ])
                    ->columns(4)
                    ->live()
                    ->afterStateUpdated(fn (\Filament\Forms\Get $get, \Filament\Forms\Set $set) => self::updateTotals($get, $set, false))
                    ->columnSpanFull(),
            ]);
    }

    public static function updateTotals(\Filament\Forms\Get $get, \Filament\Forms\Set $set, bool $isItem = false): void
    {
        $items = $isItem ? $get('../../items') : $get('items');
        $allowance = 0;
        $deduction = 0;

        if (is_array($items)) {
            foreach ($items as $item) {
                $amount = (float) ($item['amount'] ?? 0);
                if (($item['type'] ?? '') === \App\Enums\SalaryComponentType::ALLOWANCE->value) {
                    $allowance += $amount;
                } elseif (($item['type'] ?? '') === \App\Enums\SalaryComponentType::DEDUCTION->value) {
                    $deduction += $amount;
                }
            }
        }

        $basic = (float) ($isItem ? $get('../../basic_salary') : $get('basic_salary'));
        $net = $basic + $allowance - $deduction;

        if ($isItem) {
            $set('../../total_allowance', $allowance);
            $set('../../total_deduction', $deduction);
            $set('../../net_salary', $net);
        } else {
            $set('total_allowance', $allowance);
            $set('total_deduction', $deduction);
            $set('net_salary', $net);
        }
    }
}
