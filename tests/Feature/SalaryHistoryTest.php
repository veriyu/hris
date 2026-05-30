<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Outlet;
use App\Models\Position;
use App\Actions\EmployeeSalaryAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalaryHistoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed'); // Run RolePermissionSeeder (Wait, this might fail if DB is empty, let's just use it if needed)
    }

    public function test_append_salary_deactivates_previous_and_activates_new()
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

        $action = app(EmployeeSalaryAction::class);

        // Append first salary
        $salary1 = $action->appendSalary($employee, [
            'basic_salary' => 5000000,
            'allowance' => 1000000,
            'deduction' => 500000,
            'effective_date' => '2026-01-01',
        ]);

        $this->assertTrue($salary1->is_active);
        $this->assertEquals(5000000, $salary1->basic_salary);

        // Append second salary
        $salary2 = $action->appendSalary($employee, [
            'basic_salary' => 6000000,
            'allowance' => 1500000,
            'deduction' => 500000,
            'effective_date' => '2027-01-01',
        ]);

        $salary1->refresh();

        // Previous salary should be deactivated
        $this->assertFalse($salary1->is_active);
        // New salary should be active
        $this->assertTrue($salary2->is_active);

        // activeSalary relation should point to salary2
        $this->assertEquals($salary2->id, $employee->activeSalary->id);
    }
}
