<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSalaryComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = \App\Models\Employee::all();
        $defaultComponents = \App\Models\SalaryComponent::where('is_default', true)->get();

        foreach ($employees as $employee) {
            foreach ($defaultComponents as $component) {
                // Determine a dummy amount based on component name
                $amount = 0;
                
                if (str_contains($component->name, 'Makan')) {
                    $amount = rand(15, 25) * 20000; // e.g. 15-25 days * 20k = 300k-500k
                } elseif (str_contains($component->name, 'Transport')) {
                    $amount = rand(15, 25) * 15000; // e.g. 15-25 days * 15k = 225k-375k
                } elseif (str_contains($component->name, 'Kesehatan')) {
                    $amount = 150000;
                } elseif (str_contains($component->name, 'Ketenagakerjaan')) {
                    $amount = 100000;
                }

                $employee->salaryComponents()->syncWithoutDetaching([
                    $component->id => ['amount' => $amount]
                ]);
            }
        }
    }
}
