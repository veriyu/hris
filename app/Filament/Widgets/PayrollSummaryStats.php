<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PayrollSummaryStats extends StatsOverviewWidget
{
    public ?int $payroll_period_id = null;

    protected function getStats(): array
    {
        if (!$this->payroll_period_id) {
            return [];
        }

        $period = \App\Models\PayrollPeriod::with(['payrolls.items'])->find($this->payroll_period_id);
        
        if (!$period) {
            return [];
        }

        $totalGrossSalary = 0;
        $totalBPJS = 0;
        $totalOtherDeductions = 0;
        $totalNetSalary = 0;

        foreach ($period->payrolls as $payroll) {
            $earnings = $payroll->items->where('type', 'Earning')->sum('amount');
            $totalGrossSalary += $payroll->basic_salary + $earnings;

            $bpjs = $payroll->items->filter(function ($item) {
                return str_contains(strtolower($item->name), 'bpjs') && $item->type === 'Deduction';
            })->sum('amount');
            $totalBPJS += $bpjs;

            $otherDeductions = $payroll->items->filter(function ($item) {
                return !str_contains(strtolower($item->name), 'bpjs') && $item->type === 'Deduction';
            })->sum('amount');
            $totalOtherDeductions += $otherDeductions;

            $totalNetSalary += $payroll->net_salary;
        }

        return [
            Stat::make('Total Gaji Sebelum Potongan', 'Rp ' . number_format($totalGrossSalary, 0, ',', '.'))
                ->description('Gaji pokok + penambah')
                ->color('gray'),
                
            Stat::make('Total Potongan BPJS', 'Rp ' . number_format($totalBPJS, 0, ',', '.'))
                ->description('Kesehatan & Ketenagakerjaan')
                ->color('danger'),
                
            Stat::make('Total Potongan Lainnya', 'Rp ' . number_format($totalOtherDeductions, 0, ',', '.'))
                ->description('Kasbon, Koperasi, dll')
                ->color('danger'),
                
            Stat::make('Total Gaji Realisasi Cair', 'Rp ' . number_format($totalNetSalary, 0, ',', '.'))
                ->description('Take Home Pay Bersih')
                ->color('success'),
        ];
    }
}
