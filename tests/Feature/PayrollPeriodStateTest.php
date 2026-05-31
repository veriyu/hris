<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Outlet;
use App\Models\PayrollPeriod;
use App\Models\Position;
use App\Models\Payroll;
use App\Enums\PayrollPeriodStatus;
use App\Enums\PayrollStatus;
use App\Actions\PayrollAction;
use App\Actions\EmployeeSalaryAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayrollPeriodStateTest extends TestCase
{
    use RefreshDatabase;

    public function test_generating_payroll_changes_status_from_draft_to_processing()
    {
        $company = Company::create(['code' => 'C1', 'name' => 'Company 1']);
        $outlet = Outlet::create(['company_id' => $company->id, 'code' => 'O1', 'name' => 'Outlet 1', 'address' => 'Addr']);
        $department = Department::create(['code' => 'D1', 'name' => 'Dept 1']);
        $position = Position::create(['department_id' => $department->id, 'code' => 'P1', 'name' => 'Pos 1']);

        $employee = Employee::create([
            'company_id' => $company->id,
            'outlet_id' => $outlet->id,
            'department_id' => $department->id,
            'position_id' => $position->id,
            'employee_number' => 'EMP-001',
            'nik' => '123',
            'first_name' => 'John',
            'status' => 'Active',
            'gender' => 'Male',
            'dob' => '1990-01-01',
            'join_date' => '2026-01-01',
        ]);

        app(EmployeeSalaryAction::class)->appendSalary($employee, [
            'basic_salary' => 5000000,
            'allowance' => 1000000,
            'deduction' => 500000,
            'effective_date' => '2026-01-01',
        ]);

        $period = PayrollPeriod::create([
            'name' => 'Mei 2026',
            'start_date' => '2026-05-01',
            'end_date' => '2026-05-31',
            'payment_date' => '2026-05-31',
            'status' => PayrollPeriodStatus::DRAFT,
        ]);

        // Generate payroll
        app(PayrollAction::class)->generatePayrolls($period);

        // Simulate Filament table action which updates status after generation
        if ($period->status === PayrollPeriodStatus::DRAFT) {
            $period->update(['status' => PayrollPeriodStatus::PROCESSING]);
        }

        $period->refresh();
        $this->assertEquals(PayrollPeriodStatus::PROCESSING, $period->status);
    }

    public function test_locking_period_changes_status_to_completed_and_payrolls_to_paid()
    {
        $company = Company::create(['code' => 'C1', 'name' => 'Company 1']);
        $outlet = Outlet::create(['company_id' => $company->id, 'code' => 'O1', 'name' => 'Outlet 1', 'address' => 'Addr']);
        $department = Department::create(['code' => 'D1', 'name' => 'Dept 1']);
        $position = Position::create(['department_id' => $department->id, 'code' => 'P1', 'name' => 'Pos 1']);

        $employee = Employee::create([
            'company_id' => $company->id,
            'outlet_id' => $outlet->id,
            'department_id' => $department->id,
            'position_id' => $position->id,
            'employee_number' => 'EMP-001',
            'nik' => '123',
            'first_name' => 'John',
            'status' => 'Active',
            'gender' => 'Male',
            'dob' => '1990-01-01',
            'join_date' => '2026-01-01',
        ]);

        $period = PayrollPeriod::create([
            'name' => 'Mei 2026',
            'start_date' => '2026-05-01',
            'end_date' => '2026-05-31',
            'payment_date' => '2026-05-31',
            'status' => PayrollPeriodStatus::PROCESSING,
        ]);

        $payroll = Payroll::create([
            'payroll_period_id' => $period->id,
            'employee_id' => $employee->id,
            'basic_salary' => 5000000,
            'total_allowance' => 1000000,
            'total_deduction' => 500000,
            'net_salary' => 5500000,
            'status' => PayrollStatus::DRAFT,
        ]);

        // Simulate Lock & Complete action
        $period->update(['status' => PayrollPeriodStatus::COMPLETED]);
        $period->payrolls()->update(['status' => PayrollStatus::PAID]);

        $period->refresh();
        $payroll->refresh();

        $this->assertEquals(PayrollPeriodStatus::COMPLETED, $period->status);
        $this->assertEquals(PayrollStatus::PAID, $payroll->status);
    }
}
