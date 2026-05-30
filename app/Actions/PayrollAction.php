<?php

namespace App\Actions;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollPeriod;
use Illuminate\Support\Facades\DB;

class PayrollAction
{
    public function generatePayrolls(PayrollPeriod $period): void
    {
        DB::transaction(function () use ($period) {
            $employees = Employee::with(['activeSalary', 'salaryComponents'])->where('status', 'Active')->get();

            foreach ($employees as $employee) {
                if (!$employee->activeSalary) {
                    continue; // Skip employee without active salary
                }

                $activeSalary = $employee->activeSalary;
                $basicSalary = $activeSalary->basic_salary;
                
                $allowance = 0;
                $deduction = 0;

                // Calculate from salary components
                foreach ($employee->salaryComponents as $component) {
                    if ($component->type === \App\Enums\SalaryComponentType::ALLOWANCE) {
                        $allowance += $component->pivot->amount;
                    } elseif ($component->type === \App\Enums\SalaryComponentType::DEDUCTION) {
                        $deduction += $component->pivot->amount;
                    }
                }

                $netSalary = $basicSalary + $allowance - $deduction;

                $payroll = Payroll::firstOrCreate(
                    [
                        'payroll_period_id' => $period->id,
                        'employee_id' => $employee->id,
                    ],
                    [
                        'basic_salary' => $basicSalary,
                        'total_allowance' => $allowance,
                        'total_deduction' => $deduction,
                        'net_salary' => $netSalary,
                        'status' => \App\Enums\PayrollStatus::DRAFT,
                    ]
                );

                // Create detailed items based on components
                if ($payroll->wasRecentlyCreated) {
                    foreach ($employee->salaryComponents as $component) {
                        $payroll->items()->create([
                            'salary_component_id' => $component->id,
                            'name' => $component->name,
                            'type' => $component->type,
                            'amount' => $component->pivot->amount,
                        ]);
                    }
                }
            }
        });
    }

    public function recalculatePayroll(Payroll $payroll): Payroll
    {
        $totalAllowance = $payroll->items()->where('type', \App\Enums\SalaryComponentType::ALLOWANCE->value)->sum('amount');
        $totalDeduction = $payroll->items()->where('type', \App\Enums\SalaryComponentType::DEDUCTION->value)->sum('amount');
        $netSalary = $payroll->basic_salary + $totalAllowance - $totalDeduction;

        $payroll->update([
            'total_allowance' => $totalAllowance,
            'total_deduction' => $totalDeduction,
            'net_salary' => $netSalary,
        ]);

        return $payroll;
    }

    public function generatePayslip(Payroll $payroll)
    {
        $payroll->load(['employee.company', 'employee.position', 'payrollPeriod', 'items']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.payslip', [
            'payroll' => $payroll,
            'employee' => $payroll->employee,
            'company' => $payroll->employee->company,
            'period' => $payroll->payrollPeriod,
            'items' => $payroll->items,
        ]);

        return $pdf->stream('payslip-' . $payroll->employee->employee_number . '-' . $payroll->payrollPeriod->name . '.pdf');
    }
}
