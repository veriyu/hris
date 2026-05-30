<?php

namespace App\Filament\Resources\Employees\RelationManagers;

use App\Actions\EmployeeSalaryAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class SalaryHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'salaryHistories';

    protected static ?string $title = 'Salary History';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('basic_salary')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),
                Forms\Components\TextInput::make('allowance')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),
                Forms\Components\TextInput::make('deduction')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->default(0),
                Forms\Components\DatePicker::make('effective_date')
                    ->required()
                    ->default(now()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('basic_salary')
            ->columns([
                Tables\Columns\TextColumn::make('effective_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('basic_salary')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('allowance')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('deduction')
                    ->money('IDR'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->defaultSort('effective_date', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                \Filament\Actions\CreateAction::make()
                    ->using(function (array $data) {
                        return app(EmployeeSalaryAction::class)->appendSalary($this->getOwnerRecord(), $data);
                    }),
            ])
            ->actions([
                // Append-only: No Edit/Delete actions here.
            ])
            ->bulkActions([
                // Append-only: No Bulk Delete
            ]);
    }
}
