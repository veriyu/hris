<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalaryComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $components = [
            ['name' => 'Tunjangan Transport', 'type' => \App\Enums\SalaryComponentType::ALLOWANCE, 'is_default' => true],
            ['name' => 'Tunjangan Makan', 'type' => \App\Enums\SalaryComponentType::ALLOWANCE, 'is_default' => true],
            ['name' => 'Tunjangan Jabatan', 'type' => \App\Enums\SalaryComponentType::ALLOWANCE, 'is_default' => false],
            ['name' => 'Bonus Kinerja', 'type' => \App\Enums\SalaryComponentType::ALLOWANCE, 'is_default' => false],
            ['name' => 'Uang Lembur (Overtime)', 'type' => \App\Enums\SalaryComponentType::ALLOWANCE, 'is_default' => false],
            ['name' => 'Potongan BPJS Kesehatan', 'type' => \App\Enums\SalaryComponentType::DEDUCTION, 'is_default' => true],
            ['name' => 'Potongan BPJS Ketenagakerjaan', 'type' => \App\Enums\SalaryComponentType::DEDUCTION, 'is_default' => true],
            ['name' => 'Potongan Koperasi', 'type' => \App\Enums\SalaryComponentType::DEDUCTION, 'is_default' => false],
            ['name' => 'Potongan Absen/Keterlambatan', 'type' => \App\Enums\SalaryComponentType::DEDUCTION, 'is_default' => false],
            ['name' => 'Cicilan Kasbon', 'type' => \App\Enums\SalaryComponentType::DEDUCTION, 'is_default' => false],
        ];

        foreach ($components as $component) {
            \App\Models\SalaryComponent::firstOrCreate(
                ['name' => $component['name']],
                [
                    'type' => $component['type'],
                    'is_default' => $component['is_default'],
                ]
            );
        }
    }
}
