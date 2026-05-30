<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Employees', \App\Models\Employee::count())
                ->description('Active employees in the company')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            Stat::make('Total Departments', \App\Models\Department::count())
                ->description('Registered departments')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('success'),
            Stat::make('Active Payroll Periods', \App\Models\PayrollPeriod::where('status', 'Draft')->count())
                ->description('Draft periods awaiting generation')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }
}
