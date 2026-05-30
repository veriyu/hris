<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\Department;
use App\Models\Outlet;
use App\Models\Position;
use App\Actions\AttendanceAction;
use App\Enums\AttendanceStatus;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $company = Company::create(['code' => 'TEST', 'name' => 'Test Company']);
        $department = Department::create(['code' => 'D01', 'name' => 'IT']);
        $outlet = Outlet::create(['code' => 'O01', 'name' => 'HQ', 'company_id' => $company->id]);
        $position = Position::create(['code' => 'P01', 'name' => 'Dev']);

        $this->employee = Employee::create([
            'company_id' => $company->id,
            'department_id' => $department->id,
            'outlet_id' => $outlet->id,
            'position_id' => $position->id,
            'employee_number' => 'EMP001',
            'nik' => '1234567890123456',
            'first_name' => 'Test',
            'last_name' => 'User',
            'gender' => 'Male',
            'dob' => '1990-01-01',
            'join_date' => '2020-01-01',
            'status' => 'Active'
        ]);
    }

    public function test_employee_can_check_in_on_time()
    {
        Carbon::setTestNow(Carbon::today()->setTime(8, 0, 0));

        $action = new AttendanceAction();
        $attendance = $action->checkIn($this->employee);

        $this->assertEquals(AttendanceStatus::PRESENT, $attendance->status);
        $this->assertDatabaseHas('attendances', [
            'employee_id' => $this->employee->id,
            'status' => AttendanceStatus::PRESENT->value
        ]);
    }

    public function test_employee_checked_in_late()
    {
        Carbon::setTestNow(Carbon::today()->setTime(8, 15, 0));

        $action = new AttendanceAction();
        $attendance = $action->checkIn($this->employee);

        $this->assertEquals(AttendanceStatus::LATE, $attendance->status);
        $this->assertDatabaseHas('attendances', [
            'employee_id' => $this->employee->id,
            'status' => AttendanceStatus::LATE->value
        ]);
    }

    public function test_employee_cannot_check_in_twice()
    {
        Carbon::setTestNow(Carbon::today()->setTime(8, 0, 0));

        $action = new AttendanceAction();
        $action->checkIn($this->employee);

        $this->expectException(ValidationException::class);
        $action->checkIn($this->employee);
    }

    public function test_employee_can_check_out()
    {
        Carbon::setTestNow(Carbon::today()->setTime(8, 0, 0));
        $action = new AttendanceAction();
        $action->checkIn($this->employee);

        Carbon::setTestNow(Carbon::today()->setTime(17, 0, 0));
        $attendance = $action->checkOut($this->employee);

        $this->assertNotNull($attendance->check_out);
        $this->assertEquals('17:00:00', $attendance->check_out->format('H:i:s'));
    }

    public function test_employee_cannot_check_out_without_check_in()
    {
        Carbon::setTestNow(Carbon::today()->setTime(17, 0, 0));
        
        $action = new AttendanceAction();
        
        $this->expectException(ValidationException::class);
        $action->checkOut($this->employee);
    }
}
