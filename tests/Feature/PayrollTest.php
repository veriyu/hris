<?php

namespace Tests\Feature;

use App\Actions\EmployeeSalaryAction;
use App\Actions\PayrollAction;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Outlet;
use App\Models\PayrollPeriod;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayrollTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_payroll_calculates_correct_net_salary()
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
            'name' => 'Jan 2026',
            'start_date' => '2026-01-01',
            'end_date' => '2026-01-31',
            'payment_date' => '2026-01-31',
        ]);

        $action = app(PayrollAction::class);
        $action->generatePayrolls($period);

        $payroll = $period->payrolls()->where('employee_id', $employee->id)->first();

        $this->assertNotNull($payroll);
        $this->assertEquals(5000000, $payroll->basic_salary);
        $this->assertEquals(1000000, $payroll->total_allowance);
        $this->assertEquals(500000, $payroll->total_deduction);
        $this->assertEquals(5500000, $payroll->net_salary); // 5m + 1m - 500k
    }

    public function test_recalculate_payroll_updates_totals()
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
            'allowance' => 0,
            'deduction' => 0,
            'effective_date' => '2026-01-01',
        ]);

        $period = PayrollPeriod::create([
            'name' => 'Jan 2026',
            'start_date' => '2026-01-01',
            'end_date' => '2026-01-31',
            'payment_date' => '2026-01-31',
        ]);

        $action = app(PayrollAction::class);
        $action->generatePayrolls($period);

        $payroll = $period->payrolls()->first();

        // Add an extra deduction item manually
        $payroll->items()->create([
            'name' => 'Late Fee',
            'type' => 'Deduction',
            'amount' => 200000,
        ]);

        $action->recalculatePayroll($payroll);

        $this->assertEquals(200000, $payroll->total_deduction);
        $this->assertEquals(4800000, $payroll->net_salary);
    }
}
