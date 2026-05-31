<?php

namespace App\Filament\Resources\PayrollPeriods\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PayrollPeriodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('payment_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('generate_payrolls')
                    ->label(fn (\App\Models\PayrollPeriod $record) => $record->status === \App\Enums\PayrollPeriodStatus::DRAFT ? 'Generate Payrolls' : 'Recalculate Payrolls')
                    ->icon(fn (\App\Models\PayrollPeriod $record) => $record->status === \App\Enums\PayrollPeriodStatus::DRAFT ? 'heroicon-o-cog' : 'heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->visible(fn (\App\Models\PayrollPeriod $record) => $record->status !== \App\Enums\PayrollPeriodStatus::COMPLETED)
                    ->action(function (\App\Models\PayrollPeriod $record) {
                        app(\App\Actions\PayrollAction::class)->generatePayrolls($record);
                        
                        if ($record->status === \App\Enums\PayrollPeriodStatus::DRAFT) {
                            $record->update(['status' => \App\Enums\PayrollPeriodStatus::PROCESSING]);
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Payroll generated successfully!')
                            ->success()
                            ->send();
                    }),
                \Filament\Actions\Action::make('lock_and_complete')
                    ->label('Lock & Complete')
                    ->icon('heroicon-o-lock-closed')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (\App\Models\PayrollPeriod $record) => $record->status === \App\Enums\PayrollPeriodStatus::PROCESSING)
                    ->action(function (\App\Models\PayrollPeriod $record) {
                        $record->update(['status' => \App\Enums\PayrollPeriodStatus::COMPLETED]);
                        $record->payrolls()->update(['status' => \App\Enums\PayrollStatus::PAID]);

                        \Filament\Notifications\Notification::make()
                            ->title('Payroll period locked and completed successfully!')
                            ->success()
                            ->send();
                    }),
                \Filament\Actions\Action::make('download_all_pdf')
                    ->label('Download All PDF')
                    ->icon('heroicon-o-archive-box')
                    ->url(fn (\App\Models\PayrollPeriod $record) => route('payroll-period.download-all', $record))
                    ->openUrlInNewTab()
                    ->color('success'),
                \Filament\Actions\Action::make('download_finance_pdf')
                    ->label('Download Finance PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (\App\Models\PayrollPeriod $record) => route('payroll-period.download-finance', $record))
                    ->openUrlInNewTab()
                    ->color('warning'),
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
