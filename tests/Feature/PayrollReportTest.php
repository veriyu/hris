<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Outlet;
use App\Models\PayrollPeriod;
use App\Models\Position;
use App\Models\User;
use App\Models\Payroll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayrollReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthorized_user_cannot_download_finance_report()
    {
        $period = PayrollPeriod::create([
            'name' => 'Mei 2026',
            'start_date' => '2026-05-01',
            'end_date' => '2026-05-31',
            'payment_date' => '2026-05-31',
        ]);

        $response = $this->get(route('payroll-period.download-finance', $period));

        $response->assertRedirect('/login');
    }

    public function test_authorized_user_can_download_finance_report_pdf()
    {
        $user = User::factory()->create();

        $company = Company::create(['code' => 'C1', 'name' => 'Company 1']);
        $outlet = Outlet::create(['company_id' => $company->id, 'code' => 'O1', 'name' => 'Outlet 1', 'address' => 'Addr']);
        $department = Department::create(['code' => 'D1', 'name' => 'Dept 1']);
        $position = Position::create(['department_id' => $department->id, 'code' => 'P1', 'name' => 'Pos 1']);
        
        $bank = Bank::create(['code' => 'BCA', 'name' => 'Bank Central Asia']);

        $employee = Employee::create([
            'company_id' => $company->id,
            'outlet_id' => $outlet->id,
            'department_id' => $department->id,
            'position_id' => $position->id,
            'bank_id' => $bank->id,
            'bank_account_name' => 'John Doe',
            'bank_account_number' => '1234567890',
            'employee_number' => 'EMP-001',
            'nik' => '123',
            'first_name' => 'John',
            'last_name' => 'Doe',
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
        ]);

        $payroll = Payroll::create([
            'payroll_period_id' => $period->id,
            'employee_id' => $employee->id,
            'basic_salary' => 5000000,
            'total_allowance' => 1000000,
            'total_deduction' => 500000,
            'net_salary' => 5500000,
            'status' => 'Paid',
        ]);

        $response = $this->actingAs($user)->get(route('payroll-period.download-finance', $period));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
