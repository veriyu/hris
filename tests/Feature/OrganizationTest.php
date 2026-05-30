<?php

namespace Tests\Feature;

use App\Actions\CompanyAction;
use App\Actions\DepartmentAction;
use App\Actions\OutletAction;
use App\Actions\PositionAction;
use App\Models\Company;
use App\Models\Department;
use App\Models\Outlet;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_company_via_action()
    {
        $action = app(CompanyAction::class);
        
        $company = $action->executeCreate([
            'code' => 'COMP01',
            'name' => 'PT Makmur Jaya'
        ]);

        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals('COMP01', $company->code);
        $this->assertDatabaseHas('companies', ['code' => 'COMP01']);
    }

    public function test_can_update_and_delete_company_via_action()
    {
        $action = app(CompanyAction::class);
        $company = $action->executeCreate(['code' => 'COMP02', 'name' => 'Old Name']);
        
        $action->executeUpdate($company, ['name' => 'New Name']);
        $this->assertEquals('New Name', $company->fresh()->name);
        
        $action->executeDelete($company);
        $this->assertSoftDeleted('companies', ['id' => $company->id]);
    }

    public function test_can_create_outlet_via_action()
    {
        $company = app(CompanyAction::class)->executeCreate(['code' => 'COMP03', 'name' => 'Test']);
        
        $action = app(OutletAction::class);
        $outlet = $action->executeCreate([
            'company_id' => $company->id,
            'code' => 'OUT01',
            'name' => 'Cabang Utama',
            'address' => 'Jl. Sudirman'
        ]);

        $this->assertInstanceOf(Outlet::class, $outlet);
        $this->assertEquals('Cabang Utama', $outlet->name);
        $this->assertDatabaseHas('outlets', ['code' => 'OUT01']);
    }

    public function test_can_manage_department_and_position_via_action()
    {
        $deptAction = app(DepartmentAction::class);
        $posAction = app(PositionAction::class);
        
        $dept = $deptAction->executeCreate(['code' => 'IT', 'name' => 'Information Technology']);
        $pos = $posAction->executeCreate(['code' => 'SE', 'name' => 'Software Engineer']);
        
        $this->assertDatabaseHas('departments', ['code' => 'IT']);
        $this->assertDatabaseHas('positions', ['code' => 'SE']);
        
        $deptAction->executeDelete($dept);
        $posAction->executeDelete($pos);
        
        $this->assertSoftDeleted('departments', ['id' => $dept->id]);
        $this->assertSoftDeleted('positions', ['id' => $pos->id]);
    }
}
