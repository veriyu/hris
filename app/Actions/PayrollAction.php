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
            $employees = Employee::with('activeSalary')->where('status', 'Active')->get();

            foreach ($employees as $employee) {
                if (!$employee->activeSalary) {
                    continue; // Skip employee without active salary
                }

                $activeSalary = $employee->activeSalary;
                $basicSalary = $activeSalary->basic_salary;
                $allowance = $activeSalary->allowance;
                $deduction = $activeSalary->deduction;
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
                        'status' => 'Draft',
                    ]
                );

                // Create default items based on active salary structure
                if ($payroll->wasRecentlyCreated) {
                    if ($allowance > 0) {
                        $payroll->items()->create([
                            'name' => 'Allowance',
                            'type' => 'Earning',
                            'amount' => $allowance,
                        ]);
                    }

                    if ($deduction > 0) {
                        $payroll->items()->create([
                            'name' => 'Deduction',
                            'type' => 'Deduction',
                            'amount' => $deduction,
                        ]);
                    }
                }
            }
        });
    }

    public function recalculatePayroll(Payroll $payroll): Payroll
    {
        $totalAllowance = $payroll->items()->where('type', 'Earning')->sum('amount');
        $totalDeduction = $payroll->items()->where('type', 'Deduction')->sum('amount');
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

        return $pdf->download('payslip-' . $payroll->employee->employee_number . '-' . $payroll->payrollPeriod->name . '.pdf');
    }
}
