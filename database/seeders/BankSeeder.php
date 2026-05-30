<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            ['code' => 'BCA', 'name' => 'Bank Central Asia'],
            ['code' => 'MANDIRI', 'name' => 'Bank Mandiri'],
            ['code' => 'BNI', 'name' => 'Bank Negara Indonesia'],
            ['code' => 'BRI', 'name' => 'Bank Rakyat Indonesia'],
            ['code' => 'BSI', 'name' => 'Bank Syariah Indonesia'],
            ['code' => 'CIMB', 'name' => 'Bank CIMB Niaga'],
        ];

        foreach ($banks as $bank) {
            \App\Models\Bank::updateOrCreate(['code' => $bank['code']], $bank);
        }
    }
}
