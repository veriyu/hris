<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SalaryComponentSeeder::class,
            DummyDataSeeder::class,
            EmployeeSalaryComponentSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@hrms.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('Super Admin');
    }
}
