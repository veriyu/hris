<?php

namespace App\Actions;

use App\Models\Employee;
use App\Models\EmployeeSalaryHistory;
use Illuminate\Support\Facades\DB;

class EmployeeSalaryAction
{
    public function appendSalary(Employee $employee, array $data): EmployeeSalaryHistory
    {
        return DB::transaction(function () use ($employee, $data) {
            // Deactivate all existing salaries
            $employee->salaryHistories()->where('is_active', true)->update(['is_active' => false]);

            // Create new active salary
            return $employee->salaryHistories()->create([
                'basic_salary' => $data['basic_salary'] ?? 0,
                'allowance' => $data['allowance'] ?? 0,
                'deduction' => $data['deduction'] ?? 0,
                'effective_date' => $data['effective_date'],
                'is_active' => true,
            ]);
        });
    }
}
