<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PayrollSummaryReport extends Page implements \Filament\Forms\Contracts\HasForms, \Filament\Tables\Contracts\HasTable
{
    use \Filament\Forms\Concerns\InteractsWithForms;
    use \Filament\Tables\Concerns\InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static string|\UnitEnum|null $navigationGroup = 'Human Resources';

    protected static ?string $navigationLabel = 'Payroll Period Report';

    protected static ?string $title = 'Payroll Period Report';

    protected static ?int $navigationSort = 6;

    protected string $view = 'filament.pages.payroll-summary-report';

    public ?int $payroll_period_id = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\Select::make('payroll_period_id')
                ->label('Payroll Period')
                ->options(\App\Models\PayrollPeriod::pluck('name', 'id'))
                ->searchable()
                ->live()
                ->required(),
        ];
    }

    public function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->query(
                \App\Models\Payroll::query()
                    ->when($this->payroll_period_id, fn($query) => $query->where('payroll_period_id', $this->payroll_period_id))
                    ->when(!$this->payroll_period_id, fn($query) => $query->whereNull('id')) // Empty state
            )
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('employee.name')
                    ->label('Karyawan')
                    ->formatStateUsing(fn ($record) => $record->employee->first_name . ' ' . $record->employee->last_name)
                    ->description(fn ($record) => $record->employee->position->name ?? '-')
                    ->searchable(['employee.first_name', 'employee.last_name']),
                    
                \Filament\Tables\Columns\TextColumn::make('employee.bank.name')
                    ->label('Info Rekening')
                    ->description(fn ($record) => $record->employee->bank_account_number ?? '-')
                    ->placeholder('Belum diatur'),
                    
                \Filament\Tables\Columns\TextColumn::make('net_salary')
                    ->label('Take Home Pay')
                    ->money('IDR')
                    ->alignEnd()
                    ->weight('bold')
                    ->color('primary'),
            ])
            ->groups([
                \Filament\Tables\Grouping\Group::make('employee.department.name')
                    ->label('Divisi')
                    ->collapsible(),
            ])
            ->defaultGroup('employee.department.name')
            ->headerActions([
                \Filament\Actions\Action::make('download_finance')
                    ->label('Cetak PDF Finance')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn () => $this->payroll_period_id ? route('payroll-period.download-finance', $this->payroll_period_id) : '#')
                    ->openUrlInNewTab()
                    ->disabled(fn () => !$this->payroll_period_id),
            ]);
    }
}
