<?php

namespace App\Filament\Employee\Resources\Payrolls\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PayrollsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payrollPeriod.name')
                    ->label('Period')
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
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\Action::make('download_payslip')
                    ->label('View PDF')
                    ->icon('heroicon-o-document-text')
                    ->url(fn (\App\Models\Payroll $record) => route('payroll.download', $record))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
