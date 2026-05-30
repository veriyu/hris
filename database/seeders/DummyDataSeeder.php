<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Outlet;
use App\Models\Department;
use App\Models\Position;
use App\Models\EmployeeSalaryHistory;
use App\Actions\EmployeeAction;
use App\Enums\EmployeeStatus;
use App\Enums\Gender;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $action = app(EmployeeAction::class);

        // 1. Create 1 Company
        $company = Company::firstOrCreate(
            ['code' => 'COMP001'],
            ['name' => 'PT Makmur Sejahtera']
        );

        // 2. Create Outlets for the single company
        $outlets = [];
        $outletNames = ['HQ Jakarta', 'Cabang Bandung', 'Cabang Surabaya', 'Cabang Medan'];
        foreach ($outletNames as $index => $name) {
            $outlets[] = Outlet::firstOrCreate(
                ['code' => 'OUT' . str_pad($index + 1, 3, '0', STR_PAD_LEFT)],
                [
                    'company_id' => $company->id,
                    'name' => $name,
                    'address' => $faker->address
                ]
            );
        }

        // 3. Create Departments
        $departments = [];
        foreach (['Information Technology', 'Human Resources', 'Finance & Accounting', 'Operations', 'Sales & Marketing'] as $index => $name) {
            $departments[] = Department::firstOrCreate(
                ['code' => 'DEPT' . str_pad($index + 1, 3, '0', STR_PAD_LEFT)],
                ['name' => $name]
            );
        }

        // 4. Create Positions
        $positions = [];
        $positionNames = ['Manager', 'Supervisor', 'Senior Staff', 'Staff'];
        foreach ($positionNames as $index => $name) {
            $positions[] = Position::firstOrCreate(
                ['code' => 'POS00' . ($index + 1)],
                ['name' => $name]
            );
        }

        // 5. Create 20 Employees via Action (to trigger user auto-creation)
        for ($i = 0; $i < 20; $i++) {
            $gender = $faker->randomElement([Gender::MALE->value, Gender::FEMALE->value]);
            $firstName = $gender === Gender::MALE->value ? $faker->firstNameMale : $faker->firstNameFemale;
            
            $department = $departments[array_rand($departments)];
            
            // Get random position
            $position = $positions[array_rand($positions)];
            
            // Format NIK correctly (16 digits)
            $nik = $faker->unique()->numerify('################');

            $employee = $action->executeCreate([
                'company_id' => $company->id,
                'outlet_id' => $outlets[array_rand($outlets)]->id,
                'department_id' => $department->id,
                'position_id' => $position->id,
                'supervisor_id' => null, // Simplified for POC
                'nik' => $nik,
                'first_name' => $firstName,
                'last_name' => $faker->lastName,
                'gender' => $gender,
                'dob' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
                'join_date' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'status' => $faker->randomElement([EmployeeStatus::ACTIVE->value, EmployeeStatus::ACTIVE->value, EmployeeStatus::RESIGNED->value]),
            ]);

            // Add Active Salary
            EmployeeSalaryHistory::firstOrCreate([
                'employee_id' => $employee->id,
            ], [
                'basic_salary' => $faker->randomElement([5000000, 7500000, 10000000, 15000000]),
                'allowance' => $faker->randomElement([500000, 1000000, 2000000]),
                'deduction' => 0,
                'effective_date' => date('Y-m-d'),
                'is_active' => true,
            ]);
        }
    }
}
