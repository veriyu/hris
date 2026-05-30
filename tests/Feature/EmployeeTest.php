<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Outlet;
use App\Models\Position;
use App\Models\User;
use App\Enums\EmployeeStatus;
use App\Enums\Gender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed'); // Run RolePermissionSeeder
    }

    public function test_employee_creation_and_user_auto_creation()
    {
        $company = Company::create(['code' => 'C1', 'name' => 'Company 1']);
        $outlet = Outlet::create(['company_id' => $company->id, 'code' => 'O1', 'name' => 'Outlet 1', 'address' => 'Addr']);
        $department = Department::create(['code' => 'D1', 'name' => 'Dept 1']);
        $position = Position::create(['department_id' => $department->id, 'code' => 'P1', 'name' => 'Pos 1']);

        $action = app(\App\Actions\EmployeeAction::class);
        $employee = $action->executeCreate([
            'nik' => '123456789',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'gender' => Gender::MALE->value,
            'dob' => '1990-01-01',
            'status' => EmployeeStatus::ACTIVE->value,
            'join_date' => '2026-01-01',
            'company_id' => $company->id,
            'outlet_id' => $outlet->id,
            'department_id' => $department->id,
            'position_id' => $position->id,
        ]);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'nik' => '123456789',
            'first_name' => 'John',
            'employee_number' => 'EMP-' . date('Y') . '-00001',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $employee->user_id,
            'name' => 'John Doe',
            'employee_number' => 'EMP-' . date('Y') . '-00001',
        ]);
        
        $user = User::find($employee->user_id);
        $this->assertTrue($user->hasRole('Employee'));
    }
}
