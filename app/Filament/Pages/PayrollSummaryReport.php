<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;

class PayrollSummaryReport extends Page implements \Filament\Forms\Contracts\HasForms
{
    use \Filament\Forms\Concerns\InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static string|\UnitEnum|null $navigationGroup = 'Human Resources';

    protected static ?string $navigationLabel = 'Payroll Period Report';

    protected static ?string $title = 'Payroll Period Report';

    protected static ?int $navigationSort = 6;

    protected string $view = 'filament.pages.payroll-summary-report';

    public ?int $payroll_period_id = null;

    public $payrolls = [];
    public $isSubmitted = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Select::make('payroll_period_id')
                    ->label('Payroll Period')
                    ->options(\App\Models\PayrollPeriod::pluck('name', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }

    public function tampilkan()
    {
        $this->validate();

        $this->isSubmitted = true;
        $this->payrolls = \App\Models\Payroll::with(['employee.bank'])
            ->where('payroll_period_id', $this->payroll_period_id)
            ->get();
    }
}
