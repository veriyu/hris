<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Outlet;
use App\Models\Department;
use App\Models\Position;
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

        // 1. Create Companies
        $companies = [];
        foreach (['PT Nusantara Global', 'PT Teknologi Maju Raya'] as $index => $name) {
            $companies[] = Company::firstOrCreate(
                ['code' => 'COMP' . str_pad($index + 1, 3, '0', STR_PAD_LEFT)],
                ['name' => $name]
            );
        }

        // 2. Create Outlets
        $outlets = [];
        $outletNames = ['HQ Jakarta', 'Cabang Bandung', 'Cabang Surabaya', 'Cabang Medan'];
        foreach ($outletNames as $index => $name) {
            $outlets[] = Outlet::firstOrCreate(
                ['code' => 'OUT' . str_pad($index + 1, 3, '0', STR_PAD_LEFT)],
                [
                    'company_id' => $companies[array_rand($companies)]->id,
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
        foreach ($departments as $dept) {
            $positions[] = Position::firstOrCreate(
                ['code' => 'POS-' . $dept->code . '-MGR'],
                ['name' => 'Manager ' . $dept->name]
            );
            $positions[] = Position::firstOrCreate(
                ['code' => 'POS-' . $dept->code . '-STF'],
                ['name' => 'Staff ' . $dept->name]
            );
        }

        // 5. Create Employees via Action (to trigger user auto-creation)
        for ($i = 0; $i < 20; $i++) {
            $gender = $faker->randomElement([Gender::MALE->value, Gender::FEMALE->value]);
            $firstName = $gender === Gender::MALE->value ? $faker->firstNameMale : $faker->firstNameFemale;
            
            $action->executeCreate([
                'company_id' => $companies[array_rand($companies)]->id,
                'outlet_id' => $outlets[array_rand($outlets)]->id,
                'department_id' => $departments[array_rand($departments)]->id,
                'position_id' => $positions[array_rand($positions)]->id,
                'supervisor_id' => null, // Simplified for POC
                'nik' => $faker->unique()->nik(),
                'first_name' => $firstName,
                'last_name' => $faker->lastName,
                'gender' => $gender,
                'dob' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
                'join_date' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'status' => $faker->randomElement([EmployeeStatus::ACTIVE->value, EmployeeStatus::ACTIVE->value, EmployeeStatus::RESIGNED->value]),
            ]);
        }
    }
}
