<?php

namespace App\Filament\Resources\PayrollPeriods\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PayrollsRelationManager extends RelationManager
{
    protected static string $relationship = 'payrolls';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('employee.first_name')
            ->columns([
                TextColumn::make('employee.first_name')
                    ->label('Employee')
                    ->searchable(),
                TextColumn::make('basic_salary')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('total_allowance')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('total_deduction')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('net_salary')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->recordActions([
                \Filament\Actions\Action::make('download_payslip')
                    ->label('View PDF')
                    ->icon('heroicon-o-document-text')
                    ->url(fn (\App\Models\Payroll $record) => route('payroll.download', $record))
                    ->openUrlInNewTab(),
                \Filament\Actions\EditAction::make()
                    ->url(fn (\App\Models\Payroll $record): string => \App\Filament\Resources\Payrolls\PayrollResource::getUrl('edit', ['record' => $record])),
            ])
            ->toolbarActions([
            ]);
    }
}
